<?php
/**
 * Delete your account.
 * @author gizmore
 */
final class Account_Delete extends GWF_Method
{
	public function isLoginRequired() { return true; }
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^account/delete$ index.php?mo=Account&me=Delete'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('delete')) {
			return $this->onDelete($module);
		}
		
		return $this->templateDelete($module);
	}
	
	private function templateDelete(Module_Account $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('pt_accrm')),
		);
		return $module->templatePHP('delete.php', $tVars);
	}
	
	private function getForm(Module_Account $module)
	{
		$data = array(
			'note' => array(GWF_Form::MESSAGE, '', $module->lang('th_accrm_note'), 0, '', '', false),
			'delete' => array(GWF_Form::SUBMIT, $module->lang('btn_accrm')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_note(Module_Account $m, $arg) { return GWF_Validator::validateString($m, 'note', $arg, 0, 4096, false); }
	private function onDelete(Module_Account $module)
	{
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateDelete($module);
		}
		
		$user = GWF_Session::getUser();
		
		if ($user->isBot()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$note = $form->getVar('note', '');
		if ($note !== '') {
			GWF_AccountDelete::insertNote($user, $note);
		}
		$this->onSendEmail($module, $user, $note);			
		
		$user->saveOption(GWF_User::DELETED, true);
		GWF_Hook::call(GWF_Hook::DELETE_USER, $user);

		GWF_Session::onLogout();
		GWF_Hook::call(GWF_Hook::LOGOUT, $user);
		
		return $module->message('msg_accrm');
	}
	
	private function onSendEmail(Module_Account $module, GWF_User $user, $note)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
//		$mail->setCC(GWF_STAFF_EMAILS);
		$mail->setSubject($module->langAdmin('ms_accrm', array($user->getVar('user_name'))));
		$mail->setBody($module->langAdmin('mb_accrm', array($user->displayUsername(), $note)));
		return $mail->sendAsHTML(GWF_STAFF_EMAILS);
	}
	
}