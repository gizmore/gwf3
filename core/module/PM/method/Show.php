<?php

final class PM_Show extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^pm/show/(\d+)/[^/]+$ index.php?mo=PM&me=Show&pmid=$1'.PHP_EOL.
			'RewriteRule ^pm/show/(\d+)/[^/]+/([^/]+)$ index.php?mo=PM&me=Show&pmid=$1&term=$2'.PHP_EOL.
			'RewriteRule ^pm/show_translated/(\d+)/[^/]+$ index.php?mo=PM&me=Show&pmid=$1&translate=please'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		GWF_Website::addJavascript(Common::getProtocol().'://www.google.com/jsapi');
		GWF_Website::addJavascriptInline('google.load("language", "1");');
		
		GWF_Website::setPageTitle($this->pm->display('pm_title'));
		
		return $this->templateShow(Common::getGet('translate')!==false);
	}
	
	/**
	 * @var GWF_PM
	 */
	private $pm;
	
	private function sanitize()
	{
		if (false === ($this->pm = GWF_PM::getByID(Common::getGet('pmid')))) {
			return $this->module->error('err_pm');
		}
		if (false === ($this->pm->canRead(GWF_Session::getUser()))) {
			return $this->module->error('err_perm_read');
		}
		
//		$this->term = Common::getGet('term', '');
		
		return false;
	}

	private function templateShow($translate)
	{
		$pm = $this->pm;
		
		$pm->markRead(GWF_Session::getUser());
		
		
		$sender = $this->module->lang('th_pm_from').'&nbsp;'.$pm->getSender()->displayProfileLink();
		$receiver = $this->module->lang('th_pm_to').'&nbsp;'.$pm->getReceiver()->displayProfileLink();
		
		if ('' === ($translated = $this->getTranslated($translate))) {
			$translated = $pm->displayMessage();
		}
		
		$tVars = array(
			'pm' => $this->pm,
			'actions' => true,
			'title' => $this->pm->display('pm_title'),
			'unread' => GWF_PM::getUnreadPMs($this->module, GWF_Session::getUserID()),
			'translated' => $translated,
			'sender' => $sender,
			'receiver' => $receiver,
			'sendrec' => $pm->isRecipient() ? $sender : $receiver,
//			'term' => $this->term,
			'transid' => 'pm_trans_'.$pm->getID(),
			'buttons' => $this->getButtons($this->pm),
		);
		return $this->module->template('show.tpl', $tVars);
	}
	
	private function getButtons(GWF_PM $pm)
	{
		$transid = 'pm_trans_'.$pm->getID();
		$u = GWF_Session::getUser();
		$buttons = '';
		if (false !== ($prevs = $pm->getReplyToPrev())) {
			foreach ($prevs as $prev) {
				$buttons .= GWF_Button::prev($prev->getDisplayHREF(), $this->module->lang('btn_prev'));
			}
		}
		
		if (!$pm->hasDeleted($u)) {
			$buttons .= GWF_Button::delete($pm->getDeleteHREF($u->getID()), $this->module->lang('btn_delete'));
		}
		else {
			$buttons .= GWF_Button::restore($pm->getRestoreHREF(), $this->module->lang('btn_restore'));
		}
		if ($pm->canEdit($u)) {
			$buttons .= GWF_Button::edit($pm->getEditHREF(), $this->module->lang('btn_edit'));
		}
		$buttons .= GWF_Button::options($pm->getAutoFolderHREF(), $this->module->lang('btn_autofolder'));
		if (!$pm->isGuestPM()) {
			$buttons .= GWF_Button::reply($pm->getReplyHREF(), $this->module->lang('btn_reply')).PHP_EOL.GWF_Button::quote($pm->getQuoteHREF(), $this->module->lang('btn_quote'));
		}
		$u2 = $pm->getOtherUser($u);
		$buttons .= GWF_Button::ignore($pm->getIgnoreHREF($pm->getOtherUser($u)), $this->module->lang('btn_ignore', array( $u2->display('user_name'))));
		
		$buttons .= GWF_Button::translate($pm->getTranslateHREF(), $this->module->lang('btn_translate'), '', 'gwfGoogleTrans(\''.$transid.'\'); return false;');
		
		if (false !== ($nexts = $pm->getReplyToNext())) {
			foreach ($nexts as $next) {
				$buttons .= GWF_Button::next($next->getDisplayHREF(), $this->module->lang('btn_next'));
			}
		}
		return $buttons;
	}
	
	private function getTranslated($translate)
	{
		if ($translate === false) {
			return '';
		}
		
		$text = $this->pm->displayMessage();
		if (false !== ($back = GWF_GTranslate::translate($text, 'auto', GWF_Language::getCurrentISO()))) {
			return $back;
		}
		
		return '';
	}
	
}

?>