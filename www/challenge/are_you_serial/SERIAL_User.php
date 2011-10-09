<?php
final class SERIAL_User
{
	public $username = '';
	public $password = '';
	public $userlevel = 0;
	
	public function __construct($username, $password, $userlevel=0)
	{
		$this->username = $username;
		$this->password = $password;
		$this->userlevel = $userlevel;
	}
	
	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getUserlevel()
	{
		return $this->userlevel;
	}
}
?>