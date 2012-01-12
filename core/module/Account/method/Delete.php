<?php
/**
 * Delete your account.
 * @author gizmore
 */
final class Account_Delete extends GWF_Method
{
	public function isLoginRequired() { return true; }
	public function getHTAccess()
	{
		return 'RewriteRule ^account/delete$ index.php?mo=Account&me=Delete'.PHP_EOL;
	}

	public function execute()
	{
		if (false !== Common::getPost('delete')) {
			return $this->onDelete();
		}
		
		return $this->templateDelete();
	}
	
	private function templateDelete()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('pt_accrm')),
		);
		return $this->_module->template('delete.tpl', $tVars);
	}
	
	private function getForm()
	{
		$data = array(
			'note' => array(GWF_Form::MESSAGE, '', $this->_module->lang('th_accrm_note')),
			'delete' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_accrm')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_note(Module_Account $m, $arg) { return GWF_Validator::validateString($m, 'note', $arg, 0, 4096, false); }
	private function onDelete()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateDelete();
		}
		
		$user = GWF_Session::getUser();
		
		if ($user->isBot()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$note = $form->getVar('note', '');
		if ($note !== '') {
			GWF_AccountDelete::insertNote($user, $note);
		}
		$this->onSendEmail($this->_module, $user, $note);			
		
		$user->saveOption(GWF_User::DELETED, true);
		GWF_Hook::call(GWF_Hook::DELETE_USER, $user);

		GWF_Session::onLogout();
		GWF_Hook::call(GWF_Hook::LOGOUT, $user);
		
		return $this->_module->message('msg_accrm');
	}
	
	private function onSendEmail(Module_Account $module, GWF_User $user, $note)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
//		$mail->setCC(GWF_STAFF_EMAILS);
		$mail->setSubject($this->_module->langAdmin('ms_accrm', array($user->getVar('user_name'))));
		$mail->setBody($this->_module->langAdmin('mb_accrm', array($user->displayUsername(), $note)));
		return $mail->sendAsHTML(GWF_STAFF_EMAILS);
	}
	
}
