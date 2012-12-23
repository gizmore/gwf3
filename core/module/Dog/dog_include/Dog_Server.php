<?php
final class Dog_Server extends GDO
{
	const LOGGING_ON = 0x01;
	const LOGGING_OFF = 0x02;
	const ACTIVE = 0x10;
	const SSL = 0x20;
	const BNC = 0x40;
	const WS = 0x80;
	const HAS_CONNECTED_ONCE = 0x100;
	const DEFAULT_OPTIONS = 0x11;
	const LOGBITS = 0x03;
	
	/**
	 * @var Dog_IRC
	 */
	private $connection = NULL;
	private $next_connect = 0;
	private $channels = array();
	private $users = array();
	
	private $attempt = 0;
	private $nicknum = 0;
	
	private $msgs_sent = 0;
	private $msgs_time = 0;
	
	/**
	 * @var Dog_Nick
	 */
	private $nick = NULL;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_servers'; }
	public function getOptionsName() { return 'serv_options'; }
	public function getColumnDefines()
	{
		return array(
			'serv_id' => array(GDO::AUTO_INCREMENT),
			'serv_host' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 127),
			'serv_port' => array(GDO::UMEDIUMINT, '6667'),
			'serv_lang' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'en', 4),
			'serv_usermodes' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', 63),
			'serv_chanmodes' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', 63),
			'serv_triggers' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, NULL, 8),
			'serv_options' => array(GDO::UINT, self::DEFAULT_OPTIONS),
		);
	}

	public function isSSL() { return $this->isOptionEnabled(self::SSL); }
	public function isBNC() { return $this->isOptionEnabled(self::BNC); }
	public function isActive() { return $this->isOptionEnabled(self::ACTIVE); }
	public function isLogging() { return $this->isOptionEnabled(self::LOGGING_OFF) ? false : $this->isOptionEnabled(self::LOGGING_ON); }
	public function isConnected() { return $this->connection->isConnected() && $this->connection->alive(); }
	public function hasConnectedOnce() { return $this->isOptionEnabled(self::HAS_CONNECTED_ONCE); }
	public function getID() { return $this->getVar('serv_id'); }
	public function getTLD() { return self::parseTLD($this->getHost()); }
	public function displaySSL() { return $this->isSSL() ? '(TLS)' : ''; }
	public function displayName() { $b = $this->isConnected() ? chr(2) : ''; return sprintf('%s%s%s-%s', $b, $this->getID(), $b, $this->getTLD()); }
	public function displayLongName() { $b = $this->isConnected() ? chr(2) : ''; return sprintf('%s%s%s-%s', $b, $this->getID(), $b, $this->getTLD()); }
	public function displayLang() { return GWF_Language::displayNameByISO($this->getLangISO()); }
	public function getURL() { return "{$this->getHost()}:{$this->getPort()}"; }
	public function getName() { return $this->getTLD(); }
	public function getHost() { return $this->getVar('serv_host'); }
	public function getPort() { return $this->getVar('serv_port'); }
	public function getLangISO() { return $this->getVar('serv_lang'); }
	public function getRetries() { return (int)$this->getConf('retries', 20); }
	public function getTimeout() { return (int)$this->getConf('timeout', 5); }
	public function getThrottle() { return (int)$this->getConf('throttle', 3); }
	public function getTriggers() { return $this->getVar('serv_triggers'); }
	public function getIncreaseNicknum() { return $this->nicknum++; }
	public static function getAllServers() { return self::table(__CLASS__)->selectAll('*', '', 'serv_id ASC', NULL, -1, -1, self::ARRAY_O); }
	public function setConnectIn($seconds) { $this->next_connect = microtime(true) + $seconds; }
	public function setNick(Dog_Nick $nick) { $this->nick = $nick; }
	public static function parseTLD($host) { return preg_match('/([^\\.]+\\.[^\\.]+)$/', $host, $m) ? $m[1] : $host; }
	public function getChannels() { return $this->channels; }
	public function nextNick() { return Dog_Nick::getNickFor($this, $this->getIncreaseNicknum()); }
	public function getConf($key, $def='0') { return Dog_Conf_Plug_Serv::getConf('servers', $this->getID(), $key, $def); }
	public function setConf($key, $val='1') { return Dog_Conf_Plug_Serv::setConf('servers', $this->getID(), $key, $val); }
	public function isWebsocket() { return $this->isOptionEnabled(self::WS); }
	/**
	 * @return Dog_Nick
	 */
	public function getNick() { return $this->nick; }
	
	public function setNickName($nickname)
	{
		$this->setNick(new Dog_Nick(array(
			'nick_sid' => $this->getID(),
			'nick_name' => $nickname,
		)));
	}
	
	/**
	 * @return Dog_IRC
	 */
	public function getConnection() { return $this->connection; }

	/**
	 * @param string $tld
	 * @return Dog_Server
	 */
	public static function getByTLD($tld)
	{
		$ehost = self::escape($tld);
		return self::table(__CLASS__)->selectFirstObject('*', "serv_host RLIKE '\\.?$ehost$'");
	}
	
	/**
	 * Get or create a server. Check for servers in DB that have same TLD.
	 * @param string $host
	 * @param int $port
	 * @param int $options
	 * @return Dog_Server
	 */
	public static function getOrCreate($host, $port=6667, $options=self::DEFAULT_OPTIONS)
	{
		if (false !== ($server = self::getByTLD(self::parseTLD($host))))
		{
			return $server;
		}
		$server = new self(array(
			'serv_id' => '0',
			'serv_host' => $host,
			'serv_port' => $port,
			'serv_lang' => 'en',
			'serv_triggers' => NULL,
			'serv_options' => $options,
		));
		
		if (false === $server->insert())
		{
			return false;
		}
		$server->setup();
		return $server;
	}
	
	private function setup()
	{
		return GDO::table('Dog_Nick')->insertAssoc(array(
			'nick_id' => '0',
			'nick_sid' => $this->getID(),
			'nick_name' => Dog::getServer()->getNick()->getName(),
			'nick_pass' => NULL,
			'nick_options' => 0,
		));
	}
	
	public function setLogging($mode)
	{
		
		if ($mode === NULL)
		{
			return $this->saveOption(self::LOGBITS, false);
		}
		elseif ($mode === 1)
		{
			return $this->saveOption(self::LOGGING_ON, true) && $this->saveOption(self::LOGGING_OFF, false);
		}
		elseif ($mode === 0)
		{
			return $this->saveOption(self::LOGGING_ON, false) && $this->saveOption(self::LOGGING_OFF, true);
		}
		else
		{
			return Dog_Log::warn('Invalid logging mode in Server->setLogging: '.$mode);
		}
	}
	
	public function setupConnection()
	{
		if ($this->isWebsocket())
		{
			$this->connection = new Dog_IRCWS($this);
		}
		else
		{
			$this->connection = new Dog_IRCC();
		}
	}
	
	public function connect()
	{
		if ($this->next_connect <= microtime(true))
		{
			$this->attempt++;
			echo "Dog_IRC::connect() to {$this->getURL()}{$this->displaySSL()} attempt {$this->attempt}.\n";
			if (false === $this->connection->connect($this))
			{
				$this->setConnectIn($this->getNextConnectTime());
				if (false !== ($connector = $this->getVarDefault('dog_connector', false)))
				{
					$connector instanceof Dog_User;
					$connector->sendPRIVMSG(Dog::lang('err_connecting', array($this->displayLongName())));
				}
				
				if ( ($this->attempt > 3) && (!$this->hasConnectedOnce()) )
				{
					Dog::removeServer($this);
					$this->delete();
				}
				
				return false;
			}
			else
			{
				$this->attempt = 0;
				return Dog_Auth::connect($this);
			}
		}
	}
	
	public function disconnect($message)
	{
		if ($this->connection !== NULL)
		{
			# Disconnect
// 			Dog_Log::debug('Disconnect from '.$this->getHost());
			$this->connection->disconnect($message);
			
			# Reset attributes
// 			$this->connection = NULL;
			$this->next_connect = 0;
			$this->channels = array();
			$this->users = array();
			$this->attempt = 0;
			$this->nicknum = 0;

			# Reconnect plox
			$this->setConnectIn($this->getNextConnectTime());
		}
	}
	
	private function getNextConnectTime()
	{
		return Common::clamp($this->attempt * 10, 10, 900);
	}
	
	public function getMessage()
	{
		return $this->connection->alive() ? $this->connection->receive() : false;
	}
	
	private function getReplyTarget()
	{
		return false === ($channel = Dog::getChannel()) ? Dog::getUser()->getName() : $channel->getName();
	}
	
	public function reply($message)
	{
		if ('' !== ($message = trim($message)))
		{
			$username = Dog::getUser()->getName();
			
			if (false !== ($channel = Dog::getChannel()))
			{
				$this->sendPRIVMSG($channel->getName(), $username.': '.$message);
			}
			else
			{
				$this->sendPRIVMSG($username, $message);
			}
		}
	}
	
	private function logOutput($to, $message)
	{
		if ($this->isLogging())
		{
			if (false !== ($channel = Dog::getChannel()))
			{
				Dog_Log::channel($channel, $message);
			}

			if (false !== ($user = $this->getUserByName($to)))
			{
				Dog_Log::user($user, $message);
			}
		}
	}
	
	public function sendRAW($message)
	{
		$this->connection->sendRAW($message);
	}
	
	public function sendPRIVMSG($to, $message)
	{
		$this->logOutput($to, $message);
		$this->connection->sendPRIVMSG($to, $message);
	}

	public function sendCTCP($to, $message)
	{
		$this->sendNOTICE($to, chr(1).$message.chr(1));
	}
	
	public function sendNOTICE($to, $message)
	{
		$this->logOutput($to, $message);
		$this->connection->sendNOTICE($to, $message);
	}
	
	public function sendAction($to, $message)
	{
		$this->connection->sendAction($to, $message);
	}
	
	public function replyAction($message)
	{
		$this->sendAction($this->getReplyTarget(), $message);
	}
	
	/**
	 * @param string $name
	 * @return Dog_Channel
	 */
	public function getChannelByName($chan_name)
	{
		foreach ($this->channels as $channel)
		{
			$channel instanceof Dog_Channel;
			if (!strcasecmp($channel->getName(), $chan_name))
			{
				return $channel;
			}
		}
		return false;
	}
	
	public function addChannel(Dog_Channel $channel)
	{
		$this->channels[$channel->getID()] = $channel;
	}
	
	public function removeChannel(Dog_Channel $channel)
	{
		unset($this->channels[$channel->getID()]);
	}
	
	public function addUser(Dog_User $user)
	{
		$this->users[$user->getID()] = $user;
	}
	
	public function removeUser(Dog_User $user)
	{
		foreach($this->channels as $channel)
		{
			$channel instanceof Dog_Channel;
			$channel->removeUser($user);
		}
		unset($this->users[$user->getID()]);
	}
	
	public function getUsers()
	{
		return $this->users;
	}
	
	public function getUserByID($uid)
	{
		return isset($this->users[$uid]) ? $this->users[$uid] : false;
	}

	public function getUserByName($username)
	{
		foreach ($this->users as $user)
		{
			$user instanceof Dog_User;
			if (!strcmp($user->getName(), $username))
			{
				return $user;
			}
		}
		return false;
	}
	
	public function joinChannel(Dog_Channel $channel)
	{
		$this->sendRAW("JOIN {$channel->getName()}");
	}

	public function partChannel(Dog_Channel $channel)
	{
		$this->sendRAW("PART {$channel->getName()}");
	}
	
	public function sendQueue()
	{
		$now = microtime(true);
		if (($now - $this->msgs_time) >= 3.0)
		{
			$this->msgs_sent = 0;
			$this->msgs_time = $now;
		}
		else
		{
			$this->msgs_sent = $this->connection->sendQueue($this->msgs_sent, $this->getThrottle());			
		}
	}
}
?>
