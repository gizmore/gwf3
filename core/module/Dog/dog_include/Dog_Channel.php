<?php
final class Dog_Channel extends GDO
{
	const LOGGING_ON = 0x01;
	const LOGGING_OFF = 0x02;
	const AUTO_JOIN = 0x10;
	const BOLD = 0x100;
	const COLORS = 0x200;
	const ACTIONS = 0x400;
	const NOTICES = 0x800;
	
	const DEFAULT_OPTIONS = 0xF11;
	const LOGBITS = 0x03;
	
	private $users = array();
	private $privs = array();
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_channels'; }
	public function getOptionsName() { return 'chan_options'; }
	public function getColumnDefines()
	{
		return array(
			'chan_id' => array(GDO::AUTO_INCREMENT),
			'chan_sid' => array(GDO::UMEDIUMINT, GDO::NOT_NULL),
			'chan_name' => array(GDO::VARCHAR|GDO::BINARY|GDO::CASE_S, GDO::NOT_NULL, 64),
			'chan_lang' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'en', 4),
			'chan_pass' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NULL, 64),
			'chan_modes' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', 64),
			'chan_triggers' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, NULL, 8),
			'chan_options' => array(GDO::UMEDIUMINT, self::DEFAULT_OPTIONS),
		);
	}
	
	public function getID() { return $this->getVar('chan_id'); }
	public function getSID() { return $this->getVar('chan_sid'); }
	public function getName() { return $this->getVar('chan_name'); }
	public function displayName() { return $this->getName(); }
	public function displayLongName() { return $this->getServer()->displayName().$this->getName(); }
	public function displayLang() { return GWF_Language::displayNameByISO($this->getLangISO()); }
	public function getLangISO() { return $this->getVar('chan_lang'); }
	public function getTriggers() { return $this->getVar('chan_triggers'); }
	public function isLogging() { return $this->isOptionEnabled(self::LOGGING_OFF) ? false : $this->isOptionEnabled(self::LOGGING_ON); }
	public function sendAction($message) { $this->getServer()->sendAction($this->getName(), $message); }
	public function sendNOTICE($message) { $this->getServer()->sendNOTICE($this->getName(), $message); }
	public function sendPRIVMSG($message) { $this->getServer()->sendPRIVMSG($this->getName(), $message); }
	public function getUsers() { return $this->users; }
	public function getUserCount() { return count($this->users); }

	public function isBoldEnabled() { return $this->isOptionEnabled(self::BOLD); }
	public function isColorEnabled() { return $this->isOptionEnabled(self::COLORS); }
	public function isActionsEnabled() { return $this->isOptionEnabled(self::ACTIONS); }
	public function isNoticesEnabled() { return $this->isOptionEnabled(self::NOTICES); }
	public function setUIStates() { $this->setColorState(); $this->setBoldState(); }
	public function setBoldState() { GWF_IRCUtil::andBoldEnabled($this->isBoldEnabled()); }
	public function setColorState() { GWF_IRCUtil::andColorsEnabled($this->isColorEnabled()); }
	public function resetUIStates() { GWF_IRCUtil::setEnabled(); }
		
	/**
	 * @return Dog_Server
	 */
	public function getServer() { return Dog::getServerByID($this->getSID()); }
	
	/**
	 * @param int $id
	 * @return Dog_Channel
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * @param int $sid
	 * @param string $name
	 * @return Dog_Channel
	 */
	public static function getForServer($sid, $name)
	{
		$where = sprintf('chan_sid=\'%s\' AND chan_name=\'%s\'', self::escape($sid), self::escape($name));
		return self::table(__CLASS__)->selectFirstObject('*', $where);
	}
	
	/**
	 * Get the bot itself in this channel.
	 * @return Dog_User
	 */
	public function getDog()
	{
		return $this->getUserByName($this->getServer()->getNick()->getName());
	}

	/**
	 * @param string $username
	 * @return Dog_User
	 */
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
	
	public function getUserByID($uid)
	{
		foreach ($this->users as $user)
		{
			$user instanceof Dog_User;
			if ($user->getID() === $uid)
			{
				return $user;
			}
		}
		return false;
	}
	
	/**
	 * @param string $username
	 * @return Dog_User
	 */
	public function getUserByAbbrev($username)
	{
		foreach ($this->users as $user)
		{
			$user instanceof Dog_User;
			if (stripos($user->getName(), $username) === 0)
			{
				return $user;
			}
		}
		foreach ($this->users as $user)
		{
			$user instanceof Dog_User;
			if (stripos($user->getName(), $username) !== false)
			{
				return $user;
			}
		}
		return false;
	}
	
	public function addUser(Dog_User $user, $priv_symbols='')
	{
		$this->users[$user->getID()] = $user;
		$this->privs[$user->getID()] = Dog_IRCPriv::symbolsToChar($priv_symbols);
	}
	
	public function removeUser(Dog_User $user)
	{
		unset($this->users[$user->getID()]);
	}
	
	public function getPriv(Dog_User $user)
	{
		return $this->privs[$user->getID()];
	}
	
	/**
	 * Add or remove a privilege for a user in a channel.
	 * @param Dog_User $user
	 * @param char $priv
	 * @param boolean $bool
	 */
	public function setUser(Dog_User $user, $priv, $bool=true)
	{
		$uid = $user->getID();
		$has = strpos($this->privs[$uid], $priv) !== false;
		if ($bool)
		{
			if (!$has)
			{
				$this->privs[$uid] .= $priv;
			}
		}
		elseif ($has)
		{
			$this->privs[$uid] = str_replace($priv, '', $this->privs[$uid]);
		}
	}
	
	/**
	 * @param int $sid
	 * @param string $name
	 * @return Dog_Channel
	 */
	public static function getOrCreate(Dog_Server $server, $name)
	{
		$sid = $server->getID();
		if (false !== ($channel = self::getForServer($sid, $name)))
		{
			return $channel;
		}
		
		$channel = new self(array(
			'chan_id' => '0',
			'chan_sid' => $sid,
			'chan_name' => $name,
			'chan_lang' => $server->getLangISO(),
			'chan_pass' => NULL,
			'chan_modes' => '',
			'chan_triggers' => NULL,
			'chan_options' => self::DEFAULT_OPTIONS,
		));
		
		return $channel->insert() ? $channel : false;
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
			die('OOOPS123log');
		}
	}
	
}
?>
