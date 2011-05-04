<?php

final class Admin_LoginAs extends GWF_Method
{
	##############
	### Method ###
	##############
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		$nav = $module->templateNav();
		
		if (false !== Common::getPost('login')) {
			return $nav.$this->onLoginAs($module);
		}
		
		return $nav.$this->templateLoginAs($module);
	}
	
	################
	### Login As ###
	################
	public function validate_username(Module_Admin $module, $arg) { return false; }
	
	public function getForm(Module_Admin $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, Common::getGet('username', ''), $module->lang('th_user_name')),
			'login' => array(GWF_Form::SUBMIT, $module->lang('btn_login'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateLoginAs(Module_Admin $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_login_as')),
		);
		return $module->template('login_as.tpl', $tVars);
	}
	
	public function onLoginAs(Module_Admin $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateLoginAs($module);
		}
		
		if (false === ($user = GWF_User::getByName($form->getVar('username')))) {
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		
		GWF_Session::onLogin($user);
		
		return $module->message('msg_login_as', array($user->displayUsername()));
	}
	
		
}

?>