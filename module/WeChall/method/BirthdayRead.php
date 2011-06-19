<?php
final class WeChall_BirthdayRead extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		return $this->onMarkRead($module);
	}
	
	private function onMarkRead(Module_WeChall $module)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$userdata = $user->getUserData();
		$userdata['birthdaymark'] = sprintf('%02d', date('W'));
		
		if (false === $user->saveUserData($userdata)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_bd_marked');
	}
}
?>