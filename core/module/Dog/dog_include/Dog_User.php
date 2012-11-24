<?php
final class Dog_User extends GDO
{
	const BOT = 0x01;
	
	private $logged_in = false;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_users'; }
	public function getOptionsName() { return 'user_options'; }
	public function getColumnDefines()
	{
		return array(
			'user_id' => array(GDO::AUTO_INCREMENT),
			'user_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'user_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 63),
			'user_pass' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, GWF_Password::HASHLEN),
			'user_lang' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'en', 4),
			'user_options' => array(GDO::UTINYINT, 0x00),
		);
	}
	public function isBot() { return $this->isOptionEnabled(self::BOT); }
	public function getID() { return $this->getVar('user_id'); }
	public function getSID() { return $this->getVar('user_sid'); }
	public function getName() { return $this->getVar('user_name'); }
	public function getPass() { return $this->getVar('user_pass'); }
	public function getLangISO() { return $this->getVar('user_lang'); }
	public function isLoggedIn() { return $this->logged_in; }
	public function displayName() { return $this->getName(); }
	public function isRegistered() { return $this->getPass() !== NULL; }
	public function displayLang() { return GWF_Language::displayNameByISO($this->getLangISO()); }
	public function sendAction($message) { $this->getServer()->sendAction($this->getName(), $message); }
	
	public function sendCTCP($message) { $this->getServer()->sendCTCP($this->getName(), $message); }
	public function sendNOTICE($message) { $this->getServer()->sendNOTICE($this->getName(), $message); }
	public function sendPRIVMSG($message) { $this->getServer()->sendPRIVMSG($this->getName(), $message); }

	public function setLoggedIn($bool=true)
	{
		$this->logged_in = $bool;
		if ($bool)
		{
			Dog_Module::map('trigger_login', $this);
		}
		else
		{
			Dog_Module::map('trigger_logout', $this);
		}
	}
	
	/**
	 * @return Dog_Server
	 */
	public function getServer() { return Dog::getServerByID($this->getSID()); }
	
	/**
	 * @param int $id
	 * @return Dog_User
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}

	/**
	 * @param int $sid
	 * @param string $username
	 * @return Dog_User
	 */
	public static function getForServer($sid, $username)
	{
		$where = sprintf('user_sid=\'%s\' AND user_name=\'%s\'', self::escape($sid), self::escape(Common::substrUntil($username, '!')));
		return self::table(__CLASS__)->selectFirstObject('*', $where);
	}
	
	/**
	 * Get a user by long name notation, either foo!4 for server 4 or just foo for current server.
	 * @param string $name
	 * @return Dog_User
	 */
	public static function getByLongName($name)
	{
		$sid = Common::substrFrom($name, '!', Dog::getServer()->getID());
		return self::getForServer($sid, Common::substrUntil($name, '!', $name));
	}
	
	/**
	 * @param int $sid
	 * @param string $name
	 * @return Dog_User
	 */
	public static function getOrCreate($sid, $name)
	{
		if (false !== ($user = self::getForServer($sid, $name)))
		{
			return $user;
		}
		$user = new self(array(
			'user_id' => '0',
			'user_sid' => $sid,
			'user_name' => $name,
			'user_pass' => NULL,
			'user_lang' => 'en',
			'user_options' => '0',
		));
		return $user->insert() ? $user : false;
	}
}
?>
