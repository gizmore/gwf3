<?php
use Discord\Discord;

require_once 'dog_include/Dog_Includes.php';

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
    
    private function preloadChannels()
    {
        $channels = GDO::table('Dog_Channel')->selectObjects('*', 'chan_sid=' . $this->server->getID());
        foreach ($channels as $channel)
        {
            $this->server->addChannel($channel);
        }
    }
    
    public function disconnect($message)
    {}

    public function receive()
    {
        $this->nextTick();
        if ($msg = array_shift($this->messageQueue))
        {
            return $msg;
        }
        return false;
    }
    
    private function nextTick()
    {
        $this->discord->loop->futureTick(function () {
            $this->discord->loop->stop();
        });
        $this->discord->run();
    }

    public function sendRAW($message)
    {}

    public function alive()
    {
        return $this->connected;
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function sendNOTICE($to, $message)
    {
        $this->sendPRIVMSG($to, "*NOTE* {$message}");
    }

    public function sendPRIVMSG($to, $message)
    {
        $message = $this->formatMessageDiscord($message);
        if ($to[0] === '#')
        {
            if ($entry = Dog_DiscordChannels::getEntry($to))
            {
                $this->discord->guilds->fetch($entry->getGuild())->done(function($guild) use ($entry, $message) {
                    /** @var \Discord\Parts\Guild\Guild $guild **/
                    $guild->channels->fetch($entry->getChannel())->done(function($channel) use ($message) {
                        $channel->sendMessage($message);
                    });
                });
            }
        }
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
    
    private function formatMessageDiscord($text)
    {
        $text = str_replace("\x02", '**', $text);
        $text = str_replace("\x1D", '*', $text);
        return $text;
    }

    public function sendQueue($sent, $throttle)
    {
        
    }

    public function sendAction($to, $message)
    {}

    public function send($message)
    {}

    public function connect(Dog_Server $server, $blocking=0)
    {
        if ($this->connecting)
        {
            return false;
        }
        
        $this->connecting = true;
        
        $this->nick = Dog_Nick::getNickFor($server, 0);
        $server->setNick($this->nick);
        
        $this->discord = new Discord([
            'token' => $this->nick->getPass(),
            'pmChannels' => true,
        ]);
        
        $this->discord->on('ready', [$this, 'ready']);
        
        $this->discord->run();
        
        return true;
    }
    
    public function ready($discord)
    {
        echo "Discord is ready!", PHP_EOL;

        $this->connected = true;
        
        $this->preloadChannels();
        
        $this->discord->on('message', [$this, 'onMessage']);

        $this->discord->loop->futureTick(function () {
            $this->discord->loop->stop();
        });
            
    }
    
    public function onMessage($message, $discord)
    {
        echo "{$message->author->username}: {$message->content}",PHP_EOL;
        
//         var_dump($message);
        
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
                if (!$this->server->getChannelByName("#{$channelname}"))
                {
                    $this->server->addChannel($chan);
                }
                $msg = $message->content;
                $username = $message->author->user->username;
                $ircStyle = sprintf(':%s!HOST PRIVMSG %s :%s', $username, "#{$channelname}", $msg);
                $this->messageQueue[] = $ircStyle;
            });
        }

        else
        {
            $userid = $message->author->id;
            $username = $message->author->username;
            $to = $this->nick->getName();
            Dog_DiscordUsers::getOrCreateEntry($username, $userid);
            if ($userid === $this->discord->id)
            {
                return;
            }
    
            $msg = $message->content;
            $ircStyle = sprintf(':%s!HOST PRIVMSG %s :%s', $username, $to, $msg);
            $this->messageQueue[] = $ircStyle;
        }
        
    }

    
}
