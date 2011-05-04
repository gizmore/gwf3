<?php

final class Admin_Superuser extends GWF_Method
{
	##############
	### Method ###
	##############
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		$nav = $module->templateNav();
		
		# Setup / Change Password
		if (Common::getPost('setup') !== false) {
			return $nav.$this->onSetup($module);
		}
		if (Common::getGet('setup') !== false) {
			return $nav.$this->templateSetup($module);
		}
		# Prompt & Login		
		if (Common::getPost('login') !== false) {
			return $this->onLogin($module);
		}
		return $this->templatePrompt($module);
	}
	
	##############
	### Prompt ###
	##############
	public function validate_check_pass(Module_Admin $module, $arg)
	{
		return Common::checkPasswordS($arg, $module->cfgSuperHash()) ? false : $module->lang('err_check_pass');
	}
	
	public function getFormPrompt(Module_Admin $module)
	{
		$data = array(
			'check_pass' => array(GWF_Form::STRING, '', $module->lang('th_check_pass')),
			'login' => array(GWF_Form::SUBMIT, $module->lang('btn_login'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templatePrompt(Module_Admin $module)
	{
		$form = $this->getFormPrompt($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_prompt')),
		);
		return $module->template('prompt.tpl', $tVars);
	}
	
	public function onLogin(Module_Admin $module)
	{
		$form = $this->getFormPrompt($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templatePrompt($module);
		}
		
		$module->onEnteredHash();
		
		return $module->requestMethodB('Modules');
	}
	
	#############
	### Setup ###
	#############
	public function validate_new_pass() { return false; }
	public function getFormSetup(Module_Admin $module)
	{
		$data = array(
			'new_pass' => array(GWF_Form::STRING, '', $module->lang('th_new_pass')),
			'setup' => array(GWF_Form::SUBMIT, $module->lang('btn_setup'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateSetup(Module_Admin $module)
	{
		$form = $this->getFormSetup($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_setup')),
		);
		return $module->templatePHP('setup.php', $tVars);
	}
	
	public function onSetup(Module_Admin $module)
	{
		$form = $this->getFormSetup($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templatePrompt($module);
		}
		
		$plain = $newpass = $form->getVar('new_pass');
		if ($newpass !== '') {
			$newpass = GWF_Password::hashPasswordS($newpass);
		}
		$module->cfgSaveSuperhash($newpass);
		
		$key = $newpass === '' ? 'msg_pass_cleared' : 'msg_pass_set';
		return $module->message($key, array($plain));
	}
	
}

?>