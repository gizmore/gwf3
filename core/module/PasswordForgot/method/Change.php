<?php
final class PasswordForgot_Change extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^change_password/([0-9]+)/([0-9A-Za-z]+)$ index.php?mo=PasswordForgot&me=Change&token=$2&userid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		# Check token
		if (false === ($token = Common::getGet('token'))) {
			return $this->module->error('err_no_token');
		}
		if (false === ($userid = Common::getGet('userid'))) {
			return $this->module->error('err_no_token');
		}
		
		require_once GWF_CORE_PATH.'module/Account/GWF_AccountChange.php';
		if (false === ($ac = GWF_AccountChange::checkToken($userid, $token, 'pass'))) {
			return $this->module->error('err_no_token');
		}
		
		# Do stuff
		if (false !== (Common::getPost('change'))) {
			return $this->onChangePass($ac);
		}
		return $this->templateChange($ac);
	}
	
	private function getForm()
	{
		$data = array(
			'password' => array(GWF_Form::PASSWORD, '', $this->module->lang('th_password')),
			'password2' => array(GWF_Form::PASSWORD, '', $this->module->lang('th_password2')),
			'change' => array(GWF_Form::SUBMIT, $this->module->lang('btn_change'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateChange(GWF_AccountChange $ac)
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('title_change')),
			'username' => $ac->getUser()->displayUsername(),
		);
		return $this->module->templatePHP('change.php', $tVars);
	}
	
	public function validate_password2(Module_PasswordForgot $module, $password) { return false; }
	public function validate_password(Module_PasswordForgot $module, $password)
	{
		if (!GWF_Validator::isValidPassword($password)) {
			return $this->module->lang('err_weak_pass', array( 8));
		} elseif (Common::getPost('password2', '') !== $password) {
			return $this->module->lang('err_pass_retype');
		} else {
			return false;
		}
	}
	
	private function onChangePass(GWF_AccountChange $ac)
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateChange($ac);
		}
		
		$user = $ac->getUser();
		$password = $form->getVar('password');
		
		GWF_Hook::call(GWF_Hook::CHANGE_PASSWD, $user, array($password, ''));
		
		$ac->delete();
		
		if (false === $user->saveVar('user_password', GWF_Password::hashPasswordS($password)))
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}

		return $this->module->message('msg_pass_changed');
	}
}

?>