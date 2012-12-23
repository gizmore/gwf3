<?php
final class SR_DummyPlayer extends SR_Player
{
	private $dog_user = NULL;

	/**
	 * @see SR_Player::getUser()
	 */
	public function getUser() { return $this->dog_user; }
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->dog_user = new Dog_User(array('user_sid'=>'0', 'user_name'=>'__FAKE__', 'user_lang'=>'en'));
	}
}
?>
