<?php
final class SERIAL_LogoutForm
{
	public function serial_formz()
	{
		$data = array();
		$data['logout'] = array(GWF_Form::SUBMIT, 'Logout');
		return new GWF_Form($this, $data);
	}
	
	public function execute()
	{
		unset($_COOKIE['serial_user']);
		
		setcookie('serial_user', '', 0, GWF_WEB_ROOT_NO_LANG, GWF_DOMAIN, false, true);
	}
}
?>