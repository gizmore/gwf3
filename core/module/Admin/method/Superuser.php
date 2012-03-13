<?php
final class Admin_Superuser extends GWF_Method
{
	##############
	### Method ###
	##############
	public function getUserGroups() { return GWF_Group::ADMIN; }

// 	# TODO: Check what Superuser page does.
//	# XXX: This method is superuser authentication. The SetPass to set superuser has been moved to a new method SetPass now.
// 	public function getPageMenuLinks()
// 	{ 
// 		return array(
// 				array( 
// 						'page_url' => 'index.php?mo=Admin&me=Superuser',
// 						'page_title' => 'Superuser page',
// 						'page_meta_desc' => 'Change superuser password',
// 				),
// 		);
// 	}

	public function execute()
	{
		# Moved to SetPass
// 		$nav = $this->module->templateNav();
		# Setup / Change Password
// 		if (Common::getPost('setup') !== false) {
// 			return $nav.$this->onSetup();
// 		}
// 		if (Common::getGet('setup') !== false) {
// 			return $nav.$this->templateSetup();
// 		}
		
		# Prompt & Login		
		if (Common::getPost('login') !== false)
		{
			return $this->onLogin();
		}
		return $this->templatePrompt();
	}
	
	##############
	### Prompt ###
	##############
	public function validate_check_pass(Module_Admin $module, $arg)
	{
		return GWF_Password::checkPasswordS($arg, $this->module->cfgSuperHash()) ? false : $this->module->lang('err_check_pass');
	}
	
	public function getFormPrompt()
	{
		$data = array(
			'check_pass' => array(GWF_Form::STRING, '', $this->module->lang('th_check_pass')),
			'login' => array(GWF_Form::SUBMIT, $this->module->lang('btn_login'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templatePrompt()
	{
		$form = $this->getFormPrompt();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_prompt')),
		);
		return $this->module->template('prompt.tpl', $tVars);
	}
	
	public function onLogin()
	{
		$form = $this->getFormPrompt();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templatePrompt();
		}
		
		$this->module->onEnteredHash();
		
		return $this->module->requestMethodB('Modules');
	}
	# Moved to SetPass
// 	#############
// 	### Setup ###
// 	#############
// 	public function validate_new_pass() { return false; }
// 	public function getFormSetup()
// 	{
// 		$data = array(
// 			'new_pass' => array(GWF_Form::STRING, '', $this->module->lang('th_new_pass')),
// 			'setup' => array(GWF_Form::SUBMIT, $this->module->lang('btn_setup'), ''),
// 		);
// 		return new GWF_Form($this, $data);
// 	}
	
// 	public function templateSetup()
// 	{
// 		$form = $this->getFormSetup();
// 		$tVars = array(
// 			'form' => $form->templateY($this->module->lang('ft_setup')),
// 		);
// 		return $this->module->templatePHP('setup.php', $tVars);
// 	}
	
// 	public function onSetup()
// 	{
// 		$form = $this->getFormSetup();
// 		if (false !== ($error = $form->validate($this->module))) {
// 			return $error.$this->templatePrompt();
// 		}
		
// 		$plain = $newpass = $form->getVar('new_pass');
// 		if ($newpass !== '') {
// 			$newpass = GWF_Password::hashPasswordS($newpass);
// 		}
// 		$this->module->cfgSaveSuperhash($newpass);
		
// 		$key = $newpass === '' ? 'msg_pass_cleared' : 'msg_pass_set';
// 		return $this->module->message($key, array($plain));
// 	}
	
}

?>