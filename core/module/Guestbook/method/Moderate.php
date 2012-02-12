<?php
/**
 * Admin GB functions.
 * @author gizmore
 * @version 1.0
 */
final class Guestbook_Moderate extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^guestbook/edit/(\d+)$ index.php?mo=Guestbook&me=Moderate&gbid=$1'.PHP_EOL;
	}

	public function execute()
	{
		# Permissions
		if (false === ($gb = GWF_Guestbook::getByID(Common::getGet('gbid')))) {
			return $this->module->error('err_gb');
		}
		if (false === ($gb->canModerate(GWF_Session::getUser()))) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		# Toggle Moderation Flag
		if (false !== ($state = Common::getGet('set_moderation'))) {
			return $this->onSetModeration($gb, Common::getGet('gbmid', 0), $state > 0);
		}
		# Toggle Public Flag
		if (false !== ($state = Common::getGet('set_public'))) {
			return $this->onSetPublic($gb, Common::getGet('gbmid', 0), $state > 0);
		}
		
		# Edit Guestbook
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($gb).$this->templateEditGB($gb);
		}
		
		# Edit Single Entry
		if (false !== (Common::getPost('edit_entry'))) {
			return $this->onEditEntry($gb, Common::getGet('gbmid', 0), false);
		}
		if (false !== (Common::getPost('del_entry'))) {
			return $this->onEditEntry($gb, Common::getGet('gbmid', 0), true);
		}
		if (false !== (Common::getGet('edit_entry'))) {
			return $this->templateEditEntry($gb, Common::getGet('gbmid', 0));
		}
		
		return $this->templateEditGB($gb);
	}

	public function templateEditGB(GWF_Guestbook $gb)
	{
		$form = $this->getForm($gb);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit_gb')),
		);
		return $this->module->template('edit_gb.tpl', $tVars);
	}
	
	public function getForm(GWF_Guestbook $gb)
	{
		$data = array();
		
		$data['title'] = array(GWF_Form::STRING, $gb->getVar('gb_title'), $this->module->lang('th_gb_title'));
		$data['locked'] = array(GWF_Form::CHECKBOX, $gb->isLocked(), $this->module->lang('th_gb_locked'));
		$data['moderated'] = array(GWF_Form::CHECKBOX, $gb->isModerated(), $this->module->lang('th_gb_moderated'));
		$data['g_view'] = array(GWF_Form::CHECKBOX, $gb->isGuestViewable(), $this->module->lang('th_gb_guest_view'));
		$data['g_sign'] = array(GWF_Form::CHECKBOX, $gb->isGuestWriteable(), $this->module->lang('th_gb_guest_sign'));
		$data['bbcode'] = array(GWF_Form::CHECKBOX, $gb->isBBAllowed(), $this->module->lang('th_gb_bbcode'));
		$data['website'] = array(GWF_Form::CHECKBOX, $gb->isURLAllowed(), $this->module->lang('th_gb_urls'));
		$data['smileys'] = array(GWF_Form::CHECKBOX, $gb->isSmileyAllowed(), $this->module->lang('th_gb_smiles'));
		$data['emails'] = array(GWF_Form::CHECKBOX, $gb->isEMailAllowed(), $this->module->lang('th_gb_emails'));
		$data['emailentries'] = array(GWF_Form::CHECKBOX, $gb->isEMailOnSign(), $this->module->lang('th_mailonsign'));
		if ($this->module->cfgNesting()) {
			$data['nesting'] = array(GWF_Form::CHECKBOX, $gb->isNestingAllowed(), $this->module->lang('th_gb_nesting'));
		}
		$data['descr'] = array(GWF_Form::MESSAGE, $gb->getVar('gb_descr'), $this->module->lang('th_gb_descr'));
		$data['edit'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_edit_gb'));
		return new GWF_Form($this, $data);
	}
	
	public function validate_title(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['title'] = trim($arg);
		$len = GWF_String::strlen($arg);
		$max = $this->module->cfgMaxTitleLen();
		if ($len < 1 || $len > $max) {
			return $this->module->lang('err_gb_title', array( 1, $max));
		}
		return false;
	}
	
	public function validate_descr(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['descr'] = trim($arg);
		$len = GWF_String::strlen($arg);
		$max = $this->module->cfgMaxDescrLen();
		if ($len < 1 || $len > $max) {
			return $this->module->lang('err_gb_descr', array( 1, $max));
		}
		return false;
	}
	
	public function onEdit(GWF_Guestbook $gb)
	{
		$form = $this->getForm($gb);
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors;
		}
		
		$gb->saveVars(array(
			'gb_title' => $form->getVar('title'),
			'gb_descr' => $form->getVar('descr'),
		));
		$gb->saveOption(GWF_Guestbook::LOCKED, isset($_POST['locked']));
		$gb->saveOption(GWF_Guestbook::MODERATED, isset($_POST['moderated']));
		$gb->saveOption(GWF_Guestbook::ALLOW_GUEST_VIEW, isset($_POST['g_view']));
		$gb->saveOption(GWF_Guestbook::ALLOW_GUEST_SIGN, isset($_POST['g_sign']));
		$gb->saveOption(GWF_Guestbook::ALLOW_BBCODE, isset($_POST['bbcode']));
		$gb->saveOption(GWF_Guestbook::ALLOW_WEBSITE, isset($_POST['website']));
		$gb->saveOption(GWF_Guestbook::ALLOW_SMILEY, isset($_POST['smileys']));
		$gb->saveOption(GWF_Guestbook::ALLOW_EMAIL, isset($_POST['emails']));
		$gb->saveOption(GWF_Guestbook::EMAIL_ON_ENTRY, isset($_POST['emailentries']));
		if ($this->module->cfgNesting()) {
			$gb->saveOption(GWF_Guestbook::ALLOW_NESTING, isset($_POST['nesting']));
		}
		
		return $this->module->message('msg_gb_edited');
	}
	
	##################
	### Edit Entry ###
	##################
	private function getEntryForm(GWF_Guestbook $gb, GWF_GuestbookMSG $gbm)
	{
		$data = array(
			'message' => array(GWF_Form::MESSAGE, $gbm->getVar('gbm_message'), $this->module->lang('th_gbm_message')),
			'edit_entry' => array(GWF_Form::SUBMIT, $this->module->lang('btn_edit_entry')),
			'del_entry' => array(GWF_Form::SUBMIT, $this->module->lang('btn_del_entry')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateEditEntry(GWF_Guestbook $gb, $gbmid)
	{
		if (false === ($gbm = GWF_GuestbookMSG::getByID($gbmid))) {
			return $this->module->error('err_gbm');
		}
		if ($gbm->getVar('gbm_gbid') !== $gb->getID()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$form = $this->getEntryForm($gb, $gbm);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit_entry')),
		);
		return $this->module->template('edit_gbm.tpl', $tVars);
	}

	private function onEditEntry(GWF_Guestbook $gb, $gbmid, $delete=false)
	{
		if (false === ($gbm = GWF_GuestbookMSG::getByID($gbmid))) {
			return $this->module->error('err_gbm');
		}
		if ($gbm->getVar('gbm_gbid') !== $gb->getID()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
//		if (false === $gbm->mayEdit(GWF_Session::getUser())) {
//			return GWF_HTML::err('ERR_NO_PERMISSION');
//		}
		
		$form = $this->getEntryForm($gb, $gbm);
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateEditEntry($gb, $gbmid);
		}
		
		if ($delete)
		{
			if (false === $gbm->delete()) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			return $this->module->message('msg_e_deleted');
		}
		else
		{
			if (false === $gbm->saveVar('gbm_message', $form->getVar('message'))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			return $this->module->message('msg_gbm_edited');
		}
	}
	
	public function validate_message(Module_Guestbook $m, $arg)
	{
		$arg = $_POST['message'] = trim($arg);
		$len = GWF_String::strlen($arg);
		$max = $m->cfgMaxMessageLen();
		if ($len < 1 || $len > $max) {
			return $m->lang('err_gbm_message', 1, $max);
		}
		return false;
	}
	
	#########################
	### Toggle Moderation ###
	#########################
	public function onSetModeration(GWF_Guestbook $gb, $gbmid, $state)
	{
		if (false === ($gbm = GWF_GuestbookMSG::getByID($gbmid))) {
			return $this->module->error('err_gbm');
		}
		if ($gbm->getVar('gbm_gbid') !== $gb->getID()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}

		if (false === $gbm->saveOption(GWF_GuestbookMSG::IN_MODERATION, $state)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		return $this->module->message('msg_gbm_mod_'.($state ? '1' : '0'));
	}
	
	#####################
	### Toggle Public ###
	#####################
	public function onSetPublic(GWF_Guestbook $gb, $gbmid, $state)
	{
		if (false === ($gbm = GWF_GuestbookMSG::getByID($gbmid))) {
			return $this->module->error('err_gbm');
		}
		if ($gbm->getVar('gbm_gbid') !== $gb->getID()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (!$gbm->isToggleAllowed()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (false === $gbm->saveOption(GWF_GuestbookMSG::SHOW_PUBLIC, $state)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		return $this->module->message('msg_gbm_pub_'.($state ? '1' : '0'));
	}
	
}

?>
