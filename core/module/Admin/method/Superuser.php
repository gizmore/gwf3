<?php

final class Admin_Superuser extends GWF_Method
{
	##############
	### Method ###
	##############
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		$nav = $this->_module->templateNav();
		
		# Setup / Change Password
		if (Common::getPost('setup') !== false) {
			return $nav.$this->onSetup($this->_module);
		}
		if (Common::getGet('setup') !== false) {
			return $nav.$this->templateSetup($this->_module);
		}
		# Prompt & Login		
		if (Common::getPost('login') !== false) {
			return $this->onLogin($this->_module);
		}
		return $this->templatePrompt($this->_module);
	}
	
	##############
	### Prompt ###
	##############
	public function validate_check_pass(Module_Admin $module, $arg)
	{
		return GWF_Password::checkPasswordS($arg, $this->_module->cfgSuperHash()) ? false : $this->_module->lang('err_check_pass');
	}
	
	public function getFormPrompt(Module_Admin $module)
	{
		$data = array(
			'check_pass' => array(GWF_Form::STRING, '', $this->_module->lang('th_check_pass')),
			'login' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_login'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templatePrompt(Module_Admin $module)
	{
		$form = $this->getFormPrompt($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_prompt')),
		);
		return $this->_module->template('prompt.tpl', $tVars);
	}
	
	public function onLogin(Module_Admin $module)
	{
		$form = $this->getFormPrompt($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templatePrompt($this->_module);
		}
		
		$this->_module->onEnteredHash();
		
		return $this->_module->requestMethodB('Modules');
	}
	
	#############
	### Setup ###
	#############
	public function validate_new_pass() { return false; }
	public function getFormSetup(Module_Admin $module)
	{
		$data = array(
			'new_pass' => array(GWF_Form::STRING, '', $this->_module->lang('th_new_pass')),
			'setup' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_setup'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateSetup(Module_Admin $module)
	{
		$form = $this->getFormSetup($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_setup')),
		);
		return $this->_module->templatePHP('setup.php', $tVars);
	}
	
	public function onSetup(Module_Admin $module)
	{
		$form = $this->getFormSetup($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templatePrompt($this->_module);
		}
		
		$plain = $newpass = $form->getVar('new_pass');
		if ($newpass !== '') {
			$newpass = GWF_Password::hashPasswordS($newpass);
		}
		$this->_module->cfgSaveSuperhash($newpass);
		
		$key = $newpass === '' ? 'msg_pass_cleared' : 'msg_pass_set';
		return $this->_module->message($key, array($plain));
	}
	
}

?>