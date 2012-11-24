<?php
define('DOG_PATH', dirname(__FILE__).'/');
define('DOG_VERSION', '0.94a');
require_once 'dog_include/Dog_Includes.php';

final class Dog
{
	private static $TRIGGERED = false;
	
	private static $SERVERS = array();

	/**
	 * @var Dog_IRCMsg
	 */
	private static $LAST_MSG = false;
	/**
	 * @var Dog_User
	 */
	private static $LAST_USER = false;
	/**
	 * @var Dog_Channel
	 */
	private static $LAST_CHANNEL = false;
	/**
	 * @var Dog_Server
	 */
	private static $LAST_SERVER = false;
	/**
	 * @return Dog_Plugin
	 */
	public static function getPlugin()
	{
		return Dog_Plugin::getPlugin();
	}

	/**
	 * @return string
	 */
	public static function getMessage() { return self::$LAST_MSG->getRaw(); }
	public static function argc() { return self::$LAST_MSG->getArgc(); }
	public static function argv($n=NULL) { return $n === NULL ? self::$LAST_MSG->getArgs() : self::$LAST_MSG->getArg($n); }
	public static function softhyphe($s) { return GWF_Obfuscate::obfuscate($s); }
	public static function getNickname() { return self::$LAST_SERVER->getNick()->getName(); }
	
	/**
	 * @return Dog_IRCMsg
	 */
	public static function getIRCMsg() { return self::$LAST_MSG; }
	
	/**
	 * @return Dog_User
	 */
	public static function getUser() { return self::$LAST_USER; }
	public static function getUID() { return self::$LAST_USER->getID(); }
	
	/**
	 * @return Dog_User
	 */
	public static function setupUser()
	{
		self::$LAST_USER = self::$LAST_SERVER->getUserByName(Common::substrUntil(self::$LAST_MSG->getFrom(), '!'));
		return self::$LAST_USER;
	}
	
	public static function isItself()
	{
		return self::getUser()->getName() === self::getNickname();
	}
	
	/**
	 * @return Dog_Channel
	 */
	public static function getChannel() { return self::$LAST_CHANNEL; }
	
	/**
	 * @return Dog_Channel
	 */
	public static function setupChannel()
	{
		self::$LAST_CHANNEL = self::$LAST_SERVER->getChannelByName(self::$LAST_MSG->getArg(0));
		return self::$LAST_CHANNEL;
	}
	
	/**
	 * @return Dog_Server
	 */
	public static function getServer() { return self::$LAST_SERVER; }
	public static function getServers() { return self::$SERVERS; }
	
	/**
	 * @return Dog_Server
	 */
	public static function getServerByID($id)
	{
		foreach (self::$SERVERS as $server)
		{
			if ($server->getID() === $id)
			{
				return $server;
			}
		}
		return false;
	}
	
	public static function addServer(Dog_Server $server)
	{
		$server->setConnectIn(count(self::$SERVERS)*1.5+1);
		
		$tld = $server->getTLD();
		if (!isset(self::$SERVERS[$tld]))
		{
			$server->setupConnection();
			self::$SERVERS[$tld] = $server;
		}
	}
	
	public static function removeServer(Dog_Server $server)
	{
		$tld = $server->getTLD();
		unset(self::$SERVERS[$tld]);
	}
	
	public static function noPermission($priv)
	{
		self::rply('err_permission', array(Dog_IRCPriv::displayChar($priv)));
		return false;
	}
	
	public static function hasPermission(Dog_Server $serv, $chan=false, Dog_User $user, $priv, $abc=NULL)
	{
		switch ($abc)
		{
			case 'a': if ($chan !== false) { return false; } # works not in channel vvv fallthrough
			case 'b': $chan = false; break;                  # need server perms
			case 'c': if ($chan === false) { return false; } # only channel
		}
		
		$priv = Dog_IRCPriv::charToBit($priv);
		
		return $chan === false
			? Dog_PrivServer::hasPermBits($serv, $user, $priv)
			: Dog_PrivChannel::hasPermBits($chan, $user, $priv);
	}
	
	public static function lang($key, $args=NULL) { return Dog_Lang::langISO(self::getLangISO(), $key, $args); }
	public static function rply($key, $args=NULL) { self::reply(self::lang($key, $args)); }
	public static function reply($message) { self::$LAST_SERVER->reply($message); }
	public static function err($key, $args=NULL) { return self::reply(GWF_HTML::lang($key, $args)); }
	
	public static function getLangISO()
	{
		if (self::$LAST_USER !== false)
		{
			return self::$LAST_USER->getLangISO();
		}
		elseif (self::$LAST_CHANNEL !== false)
		{
			return self::$LAST_CHANNEL->getLangISO();
		}
		elseif (self::$LAST_SERVER !== false)
		{
			return self::$LAST_SERVER->getLangISO();
		}
		else
		{
			return 'en';
		}
	}
	
	/**
	 * @param string $arg
	 * @return Dog_Channel
	 */
// 	public static function getChannelByLongName($arg)
// 	{
// 		if (false === ($server = self::getServerBySuffix($arg)))
// 		{
// 			return false;
// 		}
// 		return $server->getChannelByName(Common::substrUntil($arg, '!', $arg));
// 	}
	
	/**
	 * Get a channel from cache, or load it from db.
	 * @param string $arg
	 * @return Dog_Channel
	 */
	public static function getOrLoadChannelByArg($arg)
	{
		if (false === ($server = self::getServerBySuffix($arg)))
		{
			$server = self::getServer();
		}
		
		$arg = Common::substrUntil($arg, '!', $arg);
		if (false !== ($channel = $server->getChannelByName($arg)))
		{
			return $channel;
		}
		
		return Dog_Channel::getForServer($server->getID(), $arg);
	}

	/**
	 * Get a channel by #foo!4 argument.
	 * @param string $arg
	 * @return Dog_Channel
	 */
	public static function getChannelByArg($arg)
	{
		if (false === ($server = self::getServerBySuffix($arg)))
		{
			$server = self::getServer();
		}
		return $server->getChannelByName(Common::substrUntil($arg, '!', $arg));
	}
	
	/**
	 * Returns a server from a user or channel ! notation.
	 * @param string $arg
	 * @return Dog_Server
	 */
	public static function getServerBySuffix($arg)
	{
		return self::getServerByID(Common::substrFrom($arg, '!', self::getServer()->getID()));
	}
	
	public static function getOrLoadUserByArg($arg)
	{
		Dog_Log::debug("Dog::getOrLoadUserByArg($arg)");
		
		if (false === ($server = self::getServerBySuffix($arg)))
		{
			$server = self::getServer();
		}
		
		$username = Common::substrUntil($arg, '!', $arg);
		if (false !== ($user = $server->getUserByName($username)))
		{
			return $user;
		}
		return Dog_User::getForServer($server->getID(), $username);
	}
	
	/**
	 * Get a server by ID or name abbreviation.
	 * @return Dog_Server
	 */
	public static function getServerByArg($arg)
	{
		return Common::isNumeric($arg) ? self::getServerByID($arg) : self::getServerByShortName($arg);
	}
	
	/**
	 * Get server by abbreviation.
	 * @param string $arg
	 * @return Dog_Server
	 */
	public static function getServerByShortName($arg)
	{
		foreach (self::$SERVERS as $server)
		{
			$server instanceof Dog_Server;
			
			if (stripos($server->getHost(), $arg) !== false)
			{
				return $server;
			}
		}
		return false;
	}
	
	/**
	 * Called by events to get or create the user.
	 * @return Dog_User
	 */
	public static function getOrCreateUser()
	{
		$username = Common::substrUntil(Dog::getIRCMsg()->getFrom(), '!');
		return self::getOrCreateUserByName($username);
	}
	
	/**
	 * Called by events to get or create the user.
	 * @return Dog_User
	 */
	public static function getOrCreateUserByName($username)
	{
		if (false !== ($user = self::$LAST_SERVER->getUserByName($username)))
		{
			return $user;
		}
		if (false !== ($user = Dog_User::getOrCreate(self::$LAST_SERVER->getID(), $username)))
		{
			return $user;
		}
		return false;
	}
	
	/**
	 * Get user from memory by long argument, nickname[<!sid>].
	 * @param string $arg
	 * @return Dog_User
	 */
	public static function getUserByArg($arg)
	{
		return false === ($server = self::getServerBySuffix($arg)) ? false : $server->getUserByName(Common::substrUntil($arg, '!', $arg));
	}
	
	public static function mainloop()
	{
		while (!Dog_Launcher::shouldRestart())
		{
			foreach (self::$SERVERS as $server)
			{
				$server instanceof Dog_Server;
				if ($server->isActive())
				{
					self::processServer($server);
				}
			}
			Dog_Timer::sleepAndTrigger();
		}
		Dog_Launcher::cleanup();
	}
	
	private static function processServer(Dog_Server $server)
	{
		self::$LAST_SERVER = $server;
		
		if (!$server->isConnected())
		{
			$server->connect();
			return;
		}
		
		$server->sendQueue();
		
		while (false !== ($message = $server->getMessage()))
		{
			self::processMessage($server, rtrim($message, "\r\n"));
		}
	}
	
	/**
	 * Execute a fake command. Used for calling the right help page.
	 * @example processFakeMessage('help register');
	 * @param string $message
	 */
	public static function processFakeMessage($message)
	{
		$serv = self::getServer();
		$chan = self::getChannel();
		$from = self::$LAST_MSG->getFrom();
		$to = $chan === false ? $serv->getNick()->getName() : $chan->getName();
		$trigger = self::getTrigger();
		self::processMessage(self::getServer(), sprintf(':%s PRIVMSG %s :%s%s', $from, $to, $trigger, $message));
	}
	
	/**
	 * Get the first valid trigger which would currently work.
	 * @return string .
	 */
	public static function getTrigger()
	{
		$chan = self::getChannel();
		$trigger = $chan === false ? self::getServer()->getTriggers() : $chan->getTriggers();
		$trigger = $trigger === NULL ? Dog_Init::getTriggers() : $trigger;
		return $trigger[0];
	}
	
	public static function isTriggered()
	{
		return self::$TRIGGERED;
// 		$msg = self::argv(1);
// 		return Dog_Init::isTrigger(self::getServer(), self::getChannel(), $msg[0]);
	}
	
	public static function setTriggered()
	{
		self::$TRIGGERED = true;
	}
	
	private static function processMessage(Dog_Server $server, $message)
	{
		# Clear vars that might not get set in events.
		# The events, which get executed first, will call Dog::setupUser() and Dog::setupChannel()
		self::$TRIGGERED = false;
		self::$LAST_USER = false;
		self::$LAST_CHANNEL = false;
		
		# Log to server log
		Dog_Log::server($server, $message);
		
		# Parse the message
		self::$LAST_MSG = new Dog_IRCMsg($message);
		
		# Include event code
		$event = self::$LAST_MSG->getEvent();
		$path = DOG_PATH.'dog_event/'.$event.'.php';
		if (Common::isFile($path))
		{
			include $path;
		}
		else
		{
			Dog_Log::debugMessage();
		}
		
		# Include event hooks
		$path = DOG_PATH.'event_plug/'.$event.'.php';
		if (Common::isFile($path))
		{
			include $path;
		}

		# Execute module hooks
		Dog_Module::map('event_'.$event);
	}
}
?>
