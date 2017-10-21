<?php
class DLDC_User extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dldc_users'; }
	public function getColumnDefines()
	{
		return array(
			'id' => array(GDO::AUTO_INCREMENT),
			'wechall_userid' => array(GDO::INT|GDO::UNIQUE, GDO::NOT_NULL), # One registration per player only, please
			'username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 24),
			'password' => array(GDO::CHAR|GDO::BINARY, GDO::NOT_NULL, 16),
			'level' => array(GDO::INT, 0),
			'email' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 64),
			'firstname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 64),
			'lastname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 64),
			'regdate' => array(GDO::TIME, GDO::NOT_NULL),
		);
	}
	
	public static function isUsernameValid($username)
	{
		return preg_match('/^[a-z][a-z0-9_]{2,23}$/iD', $username);
	}
	
	public static function existsUsername($username)
	{
		$table = self::table(__CLASS__);
		$username = $table->escape($username);
		return 0 !== $table->countRows("username='$username'");
	}
	
	public static function existsEMail($email)
	{
		$table = self::table(__CLASS__);
		$email = $table->escape($email);
		return 0 !== $table->countRows("email='$email'");
	}
	
	public static function hashPassword($password)
	{
		return md5($password, true);
	}
	
	public static function instance($username, $password, $email, $firstname, $lastname)
	{
		return new self(array(
			'id' => '0',
			'wechall_userid' => GWF_Session::getUserID(), # One registration per player only, please
			'username' => $username,
			'password' => self::hashPassword($password),
			'level' => '0',
			'email' => $email,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'regdate' => time(),
		));
	}
	
	public static function create($username, $password, $email, $firstname, $lastname)
	{
		$user = self::instance($username, $password, $email, $firstname, $lastname);
		$user->insert();
		return $user;
	}
	
	public static function login($username, $password)
	{
		$table = self::table(__CLASS__);
		$username = $table->escape($username);
		$password = $table->escape(self::hashPassword($password));
		return $table->selectFirstObject('*', "username='$username' AND password='$password'");
	}
	
	public function onChallengeSolved()
	{
		$this->increase('level', 1);
	}
	
	public function displayRegdate()
	{
		return GWF_Time::displayTimestamp($this->getVar('regdate'));
	}
}
