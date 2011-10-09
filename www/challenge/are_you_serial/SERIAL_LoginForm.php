<?php
final class SERIAL_LoginForm
{
	public function serial_formz()
	{
		$data = array();
		$data['username'] = array(GWF_Form::STRING, '', 'Username');
		$data['login'] = array(GWF_Form::SUBMIT, 'Login');
		return new GWF_Form($this, $data);
	}
	
	public function execute($username)
	{
		$password = 'testtest'; #random
		
		$user = new SERIAL_User($username, $password);
		
		$serial = serialize($user);
		
		$_COOKIE['serial_user'] = $serial;
		
		setcookie('serial_user', $serial, time()+31536000, GWF_WEB_ROOT_NO_LANG, GWF_DOMAIN, false, true);
	}
}
?>