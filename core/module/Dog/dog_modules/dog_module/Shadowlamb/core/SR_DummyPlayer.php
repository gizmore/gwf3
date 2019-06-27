<?php
require_once 'SR_Player.php';

final class SR_DummyPlayer extends SR_Player
{
	private static $dog_user = NULL;
	public static function getDogUser() { return self::$dog_user; }
	public function getUser() { return self::$dog_user; }
	public function __construct($data)
	{
		parent::__construct($data);
		self::$dog_user = new Dog_User(array('user_sid'=>'0', 'user_name'=>'__FAKE__', 'user_lang'=>'en'));
	}
}
