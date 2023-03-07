<?php
use Discord\Discord;

require_once 'Dog_Includes.php';

/**
 * Discord connector.
 * Uses run/stop for each tick on the react loop.
 * @author gizmore
 * @since Sep 2020
 */
final class Dog_Discord implements Dog_IRC
{
    private $server = null;
    private $discord = null;
    private $connected = false;
    private $connecting = false;
    private $nick = null;
    
    private $messageQueue = [];
    
    public function __construct(Dog_Server $server)
    {
        $this->server = $server;
        $this->initDiscordIncludes();
    }
    
    private function initDiscordIncludes()
    {
        require_once GWF_DISCORD_PATH . 'autoload.php';
    }
    
    public function disconnect($message)
    {
        if ($this->discord)
        {
            $this->discord->close();
            $this->discord = null;
        }
        $this->connected = false;
        $this->connecting = false;
        $this->messageQueue = [];
    }

    public function receive()
    {
        $this->nextTick();
        if ($msg = array_shift($this->messageQueue))
        {
            return $msg;
        }
        return false;
    }
    
    /**
     * Iterate next react loop tick.
     */
    private function nextTick()
    {
        $this->discord->loop->futureTick(function () {
            $this->discord->loop->stop();
        });
        $this->discord->run();
    }

   public function alive()
    {
        return $this->connected;
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function sendAction($to, $message)
    {
        $this->sendPRIVMSG($to, "**ACTION**: {$message}");
    }
    
    public function sendNOTICE($to, $message)
    {
        $this->sendPRIVMSG($to, "*NOTE*: {$message}");
    }

    public function sendPRIVMSG($to, $message)
    {
        $message = $this->formatMessageDiscord($message);
        
        # Channel message
        if ($to[0] === '#')
        {
            if ($entry = Dog_DiscordChannels::getEntry($to))
            {
                $this->discord->guilds->fetch($entry->getGuild())->done(function($guild) use ($entry, $message) {
                    /** @var \Discord\Parts\Guild\Guild $guild **/
                    $guild->channels->fetch($entry->getChannel())->done(function($channel) use ($message) {
                        /** @var \Discord\Parts\Channel\Channel $channel **/
                        $channel->sendMessage($message);
                    });
                });
            }
        }
        
        # User message
        else
        {
            if ($to = Dog_DiscordUsers::getGUIDFor($to))
            {
                $this->discord->users->fetch($to)->done(function($user) use ($message){
                    $user->sendMessage($message);
                });
            }
        }
    }
    
    /**
     * Convert bold and italic to markdown.
     * Remove IRC colors.
     * @param string $text
     * @return string
     */
    private function formatMessageDiscord($text)
    {
        $text = str_replace("\x02", '**', $text); # bold
        $text = str_replace("\x1D", '*', $text); # italic
        $text = preg_replace("/\x03\\d/", "", $text); # remove colors
        $text = preg_replace("/\x03/", "", $text); # remove colors
        return $text;
    }

    public function sendQueue($sent, $throttle)
    {
//         echo "SEND QUEUE NOT SUPPORTED BY DISCORD!\n";
//         This is called a lot!
    }

    public function send($message)
    {
        echo "RAW SEND NOT SUPPORTED BY DISCORD!\n";
    }

    public function sendRAW($message)
    {
        echo "SEND RAW NOT SUPPORTED BY DISCORD!\n";
    }
    
    public function connect(Dog_Server $server, $blocking=0)
    {
        if ($this->connecting)
        {
            echo "Already connecting!\n";
            return false;
        }
        
        $this->connecting = true;
        
        $this->nick = Dog_Nick::getNickFor($server, 0);
        $server->setNick($this->nick);
        
        $this->discord = new Discord([
            'token' => $this->nick->getPass(),
            'pmChannels' => true,
            'loadAllMembers' => true,
        ]);
        
        $this->discord->on('ready', [$this, 'ready']);
        
        $this->discord->run();
        
        return true;
    }
    
    public function ready($discord)
    {
        echo "Discord is ready!\n";

        $this->connected = true;
        
        $this->discord->on('message', [$this, 'onMessage']);
        $this->discord->on('PRESENCE_UPDATE', [$this, 'onPresenceUpdate']);

        $this->discord->loop->futureTick(function () {
            $this->preloadChannels();
            $this->discord->loop->stop();
        });
    }
    
    /**
     * Load all online users and channels.
     */
    private function preloadChannels()
    {
        $channels = GDO::table('Dog_Channel')->selectObjects('*', 'chan_sid=' . $this->server->getID());
        foreach ($channels as $channel)
        {
            $this->server->addChannel($channel);
            if ($entry = Dog_DiscordChannels::getEntry($channel->getName()))
            {
                $this->discord->guilds->fetch($entry->getGuild())->done(function($guild) use ($entry, $channel) {
                    /** @var \Discord\Parts\Guild\Guild $guild **/
                    foreach ($guild->members as $member)
                    {
                        /** @var \Discord\Parts\User\Member **/
                        if ($member->status === 'online')
                        {
                            $this->preloadMember($channel, $entry, $member);
                        }
                    }
                });
            }
        }
        printf("Preloaded %d channels and %d users.\n",
            count($this->server->getChannels()),
            count($this->server->getUsers()));
    }
    
    /**
     * Preload a user.
     */
    private function preloadMember($channel, $entry, $member)
    {
        $userid = $member->user->id;
        $username = $member->user->username;
        Dog_DiscordUsers::getOrCreateEntry($username, $userid);
        $user = Dog_User::getOrCreate($this->server->getID(), $username);
        $this->server->addUser($user);
        $channel->addUser($user);
    }
    
    /**
     * Message received.
     * Transform into IRC format and put on stack.
     * The message is later returned in **receive** function.
     */
    public function onMessage($message, $discord)
    {
        
        # Channel message
        if ($message->author->user)
        {
            $userid = $message->author->user->id;
            $username = $message->author->user->username;
            Dog_DiscordUsers::getOrCreateEntry($username, $userid);
            
            $guild_id = $message->author->guild_id;
            $this->discord->guilds->fetch($guild_id)->done(function($guild) use ($message) {
                /** @var \Discord\Parts\Guild\Guild $guild **/
                $channelname = $guild->name;
                Dog_DiscordChannels::getOrCreateEntry($channelname, $message->author->guild_id, $message->channel_id);
                $chan = Dog_Channel::getOrCreate($this->server, "#{$channelname}");
                $this->server->addChannel($chan);
                $msg = $message->content;
                $username = $message->author->user->username;
                $ircStyle = sprintf(':%s!HOST PRIVMSG %s :%s', $username, "#{$channelname}", $msg);
                $this->messageQueue[] = $ircStyle;
                printf("%s: %s: #%s: %s", $this->server->getName(), $username, $channelname, $message->content);
            });
        }

        # Private message
        else
        {
            $userid = $message->author->id;
            $username = $message->author->username;
            if ( (!$userid) || (!$username) )
            {
                return;
            }
            $to = $this->nick->getName();
            Dog_DiscordUsers::getOrCreateEntry($username, $userid);
            if ($userid === $this->discord->id)
            {
                return;
            }
            $msg = $message->content;
            $ircStyle = sprintf(':%s!HOST PRIVMSG %s :%s', $username, $to, $msg);
            $this->messageQueue[] = $ircStyle;
            printf("%s: %s: %s", $this->server->getName(), $username, $message->content);
        }
    }

    /**
     * Online status changed
     */
    public function onPresenceUpdate($data, $discord)
    {
        $guildId = $data->guild_id;
        $userGUID = $data->user->id;
        $username = $data->user->username;
        
        # FIX: Sometimes the username is empty. Why?
        if (!$username)
        {
            return;
        }
        
        # Get user
        Dog_DiscordUsers::getOrCreateEntry($username, $userGUID);
        $user = Dog_User::getOrCreate($this->server->getID(), $username);
        
        # Get channel
        $channel = Dog_DiscordChannels::getDogChannelByGuildId($this->server, $guildId);
        
        # Add/Remove
        if ($data->status === 'online')
        {
            $ircStyle = ":{$username}!HOST JOIN :{$channel->getName()}";
            $this->messageQueue[] = $ircStyle;
        }
        elseif ($data->status === 'offline')
        {
//             $ircStyle = ":{$username}!HOST PART :{$channel->getName()}";
//             $this->messageQueue[] = $ircStyle;
            $channel->removeUser($user);
            $this->server->removeUser($user);
        }
        elseif ($data->status === 'idle')
        {
            
        }
    }
    
}
