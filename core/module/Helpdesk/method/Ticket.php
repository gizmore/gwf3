<?php
final class Helpdesk_Ticket extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false === ($ticket = GWF_HelpdeskTicket::getByID(Common::getGet('ticket')))) {
			return $this->module->error('err_ticket');
		}
		if (!$ticket->hasPermission(GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$back = '';
		
		## Post
		if (isset($_POST['reply'])) {
			$back .= $this->onReply($ticket);
		}
		
		## Get
		
		if (isset($_GET['work'])) {
			$back .= $this->onWork($ticket);
		}
		
		if (Common::getGetString('faq') === '1') {
			$back .= $this->onFaq($ticket, true);
		}
		elseif (Common::getGetString('faq') === '0') {
			$back .= $this->onFaq($ticket, false);
		}
		
		if (Common::getGetString('infaq') === '1') {
			$back .= $this->onInFaq($ticket, true);
		}
		elseif (Common::getGetString('infaq') === '0') {
			$back .= $this->onInFaq($ticket, false);
		}
		
		if (Common::getGetString('msgfaq') === '1') {
			$back .= $this->onMsgFAQ($ticket, true);
		}
		elseif (Common::getGetString('msgfaq') === '0') {
			$back .= $this->onMsgFAQ($ticket, false);
		}
		
		if (Common::getGetString('solve') === '1') {
			$back .= $this->onSolve($ticket, 'solved');
		}
		elseif (Common::getGetString('solve') === '0') {
			$back .= $this->onSolve($ticket, 'unsolved');
		}
		
		if (isset($_GET['raise'])) {
			$back .= $this->onRaisePrio($ticket, 1);
		}
		elseif (isset($_GET['lower'])) {
			$back .= $this->onRaisePrio($ticket, -1);
		}
		
		if (isset($_GET['reply'])) {
			return $back.$this->templateTicketReply($ticket);
		}
		
		return $back.$this->templateTicket($ticket);
	}
	
	public function validate_message(Module_Helpdesk $m, $arg) { return $m->validate_message($arg); } 
	
	private function templateTicketReply(GWF_HelpdeskTicket $ticket)
	{
		$back = '';
		if ($ticket->getCreatorID() !== GWF_Session::getUserID()) {
			if ($ticket->getWorkerID() === '0') {
				$back .= $this->onWork($ticket);
			}
		}
		
		$form = $this->formReply($ticket);
		return $back.$this->templateTicket($ticket, $form->templateY($this->module->lang('ft_reply')));
	}
	
	private function templateTicket(GWF_HelpdeskTicket $ticket, $form='')
	{
		$tid = $ticket->getID();
		
		if (false === $this->markRead($ticket)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$tVars = array(
			'ticket' => $ticket,
			'messages' => GDO::table('GWF_HelpdeskMsg')->selectObjects('*', "hdm_tid=$tid", 'hdm_date ASC'),
		
			'href_raise_prio' => $this->getMethodHREF("&ticket=$tid&raise=1"),
			'href_lower_prio' => $this->getMethodHREF("&ticket=$tid&lower=1"),
			'href_reply' => $this->getMethodHREF("&ticket=$tid&reply=now"),
			'href_work' => $this->getMethodHREF("&ticket=$tid&work=now"),
			'href_solve' => $this->getMethodHREF("&ticket=$tid&solve=1"),
			'href_unsolve' => $this->getMethodHREF("&ticket=$tid&solve=0"),
			'href_faq' => $this->getMethodHREF("&ticket=$tid&faq=1"),
			'href_nofaq' => $this->getMethodHREF("&ticket=$tid&faq=0"),
			'href_infaq' => $this->getMethodHREF("&ticket=$tid&infaq=1"),
		
			'href_noinfaq' => $this->getMethodHREF("&ticket=$tid&infaq=0"),
			'creator' => $ticket->getCreator(),
			'worker' => $ticket->getWorker(),
			'is_worker' => GWF_Session::getUserID() === $ticket->getWorkerID(),
			'is_admin' => GWF_User::isAdminS(),
			'form' => $form,
		);
		return $this->module->template('ticket.tpl', $tVars);
	}
	
	private function markRead(GWF_HelpdeskTicket $ticket)
	{
		$read = GWF_HelpdeskMsg::READ;
		$tid = $ticket->getID();
		$uid = GWF_Session::getUserID();
		if (false === GDO::table('GWF_HelpdeskMsg')->update("hdm_options=hdm_options|$read", "hdm_tid=$tid AND hdm_uid!=$uid")) {
			return false;
		}
		$this->markTicketRead($ticket, true);
		return true;
	}
	
	private function formReply()
	{
		$data = array(
			'message' => array(GWF_Form::MESSAGE, '', $this->module->lang('th_message')),
			'reply' => array(GWF_Form::SUBMIT, $this->module->lang('btn_reply')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onWork(GWF_HelpdeskTicket $ticket)
	{
		$user = GWF_Session::getUser();
		if ( (!$user->isAdmin()) && (!$user->isStaff()) ) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (false === ($method = $this->module->getMethod('AssignWork'))) {
			return GWF_HTML::err('ERR_METHOD_MISSING', array('AssignWork'));
		}
		
		if ($ticket->getWorker() !== false) {
			return $this->module->error('err_two_workers');
		}
		
		return $method->onAssign($ticket, $user);
	}
	
	private function onFaq(GWF_HelpdeskTicket $ticket, $bool)
	{
		if (GWF_Session::getUserID() !== $ticket->getCreatorID()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false === $ticket->saveOption(GWF_HelpdeskTicket::ALLOW_FAQ, $bool)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$key = $bool ? 'msg_faq' : 'msg_nofaq';
		return $this->module->message($key);
	}
	
	private function onInFaq(GWF_HelpdeskTicket $ticket, $bool)
	{
		if (!GWF_User::isAdminS()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (!$ticket->isFAQ()) {
			return $this->module->error('err_no_faq');
		}
		
		if (false === $ticket->saveOption(GWF_HelpdeskTicket::VISIBLE_FAQ, $bool)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$key = $bool ? 'msg_infaq' : 'msg_noinfaq';
		return $this->module->message($key);
	}
	
	private function onMsgFAQ(GWF_HelpdeskTicket $ticket, $bool)
	{
		$tid = $ticket->getID();
		$mid = Common::getGetInt('message');
		if (false === ($message = GDO::table('GWF_HelpdeskMsg')->selectFirstObject('*', "hdm_tid=$tid AND hdm_id=$mid"))) {
			return $this->module->error('err_tmsg');
		}
		
		if (false === $message->saveOption(GWF_HelpdeskMsg::FAQ, $bool)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$key = $bool ? 'msg_mfaq_1' : 'msg_mfaq_0';
		return $this->module->message($key);
	}
	
	private function onSolve(GWF_HelpdeskTicket $ticket, $status)
	{
		if (false === $ticket->saveVar('hdt_status', $status)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->module->message('msg_solve_'.$status);
	}
	
	
	private function onRaisePrio(GWF_HelpdeskTicket $ticket, $add=1)
	{
		$add = (int) $add;
		
		if ($add === 0) {
			return '';
		}
		
		$old = $ticket->getPriority();
		
		if ($add > 0)
		{
			if ($old+$add > 20) {
				return $this->module->error('err_priority', array(0, 20));
			}
		}
		else
		{
			if ($old+$add < 0) {
				return $this->module->error('err_priority', array(0, 20));
			}
		}
		
		$old += $add;
		
		if (false === $ticket->increase('hdt_priority', $add)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		if ($add > 0) {
			return $this->module->message('msg_raised', array($add));
		}
		else {
			return $this->module->message('msg_lowered', array(-$add));
		}
	}
	
	private function onReply(GWF_HelpdeskTicket $ticket)
	{
		$form = $this->formReply();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		$options = 0;
		
		$message = new GWF_HelpdeskMsg(array(
			'hdm_id' => 0,
			'hdm_tid' => $ticket->getID(),
			'hdm_uid' => GWF_Session::getUserID(),
			'hdm_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'hdm_message' => $form->getVar('message'),
			'hdm_options' => $options,
		));
		
		if (false === $message->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->markTicketUnread($ticket, false);
		
		$this->sendReplyMail($ticket, $message);
		
		unset($_GET['reply']);
		
		return $this->module->message('msg_replied');
	}
	
	private function markTicketRead(GWF_HelpdeskTicket $ticket, $bool)
	{
		$bit = 0;
		if (GWF_Session::getUserID() == $ticket->getWorkerID()) {
			$bit |= GWF_HelpdeskTicket::STAFF_READ;
		}
		if (GWF_Session::getUserID() == $ticket->getCreatorID()) {
			$bit |= GWF_HelpdeskTicket::USER_READ;
		}
		$ticket->saveOption($bit, $bool);
	}
	
	private function markTicketUnread(GWF_HelpdeskTicket $ticket, $bool)
	{
		$bit = 0;
		if (GWF_Session::getUserID() == $ticket->getWorkerID()) {
			$bit |= GWF_HelpdeskTicket::USER_READ;
		}
		if (GWF_Session::getUserID() == $ticket->getCreatorID()) {
			$bit |= GWF_HelpdeskTicket::STAFF_READ;
		}
		$ticket->saveOption($bit, $bool);
	}
	
	private function sendReplyMail(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message)
	{
		if (GWF_Session::getUserID() == $ticket->getWorkerID())
		{
			$user = $ticket->getCreator();
			if ('' !== ($rec = $user->getValidMail()))
			{
				if ($ticket->isOptionEnabled(GWF_HelpdeskTicket::EMAIL_ME))
				{
					$this->sendReplyMailUser($ticket, $message, $user);
				}
			}
		}
		else
		{
			$user = $ticket->getWorker();
			if ('' !== ($rec = $user->getValidMail()))
			{
				$this->sendReplyMailStaff($ticket, $message, $user);
			}
		}
	}

	private function sendReplyMailUser(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message, GWF_User $user)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setSubject($this->module->langUser($user, 'subj_nmu', array($ticket->getID())));
		$link_solved = Common::getAbsoluteURL($this->module->getMethodURL('MarkSolved', sprintf('&ticket=%s&message=%s&token=%s', $ticket->getID(), $message->getID(), $message->getHashcode())));
		$link_read = Common::getAbsoluteURL($this->module->getMethodURL('MarkRead', sprintf('&ticket=%s&message=%s&token=%s', $ticket->getID(), $message->getID(), $message->getHashcode())));
		$mail->setBody($this->module->langUser($user, 'body_nmu', array($user->displayUsername(), $ticket->getWorker()->displayUsername(), $message->displayMessage(), $link_solved, $link_read)));
		$mail->sendToUser($user);
	}
	
	private function sendReplyMailStaff(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message, GWF_User $user)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($user->getValidMail());
		$mail->setSubject($this->module->langUser($user, 'subj_nms', array($ticket->getID())));
		$link_read = Common::getAbsoluteURL($this->module->getMethodURL('MarkRead', sprintf('&ticket=%s&message=%s&token=%s', $ticket->getID(), $message->getID(), $message->getHashcode())));
		$mail->setBody($this->module->langUser($user, 'body_nms', array($user->displayUsername(), $ticket->getCreator()->displayUsername(), $message->displayMessage(), $link_read)));
		$mail->sendToUser($user);
	}
}
?>
