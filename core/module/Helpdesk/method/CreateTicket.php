<?php
final class Helpdesk_CreateTicket extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Helpdesk&me=CreateTicket',
						'page_title' => 'Create Helpdesk ticket',
						'page_meta_desc' => 'Create a new Helpdesk ticket to help us improve the site',
				),
		);
	}
	
	public function execute()
	{
		require_once GWF_CORE_PATH.'module/Helpdesk/GWF_HelpdeskTitle.php';
		
		if (false !== Common::getPost('create')) {
			return $this->onCreate();
		}
		
		return $this->templateCT();
	}
	
	private function templateCT()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_new_ticket')),
		);
		return $this->module->template('new_ticket.tpl', $tVars);
	}
	
	private function getForm()
	{
		$data = array(
			'title' => array(GWF_Form::SELECT, GWF_HelpdeskTitle::select('title', Common::getPostString('title')), $this->module->lang('th_title')),
			'other' => array(GWF_Form::STRING, '', $this->module->lang('th_other')),
			'message' => array(GWF_Form::MESSAGE, '', $this->module->lang('th_message')),
			'faq' => array(GWF_Form::CHECKBOX, false, $this->module->lang('th_allow_faq'), $this->module->lang('tt_allow_faq')),
			'email' => array(GWF_Form::CHECKBOX, true, $this->module->lang('th_email_me')),
			'create' => array(GWF_Form::SUBMIT, $this->module->lang('btn_new_ticket')),
		);
		return new GWF_Form($this, $data);
	}
	
    public function validate_title($m, $arg) { return GWF_HelpdeskTitle::validate_title($m, $arg); } 
    public function validate_other($m, $arg) { return false; }
    public function validate_message($m, $arg) { return $m->validate_message($arg); }
	
	private function onCreate()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateCT();
		}
		
		$options = GWF_HelpdeskTicket::USER_READ;
		$options |= isset($_POST['faq']) ? GWF_HelpdeskTicket::ALLOW_FAQ : 0;
		$options |= isset($_POST['email']) ? GWF_HelpdeskTicket::EMAIL_ME : 0;
		
		$ticket = new GWF_HelpdeskTicket(array(
			'hdt_id' => '0',
			'hdt_uid' => GWF_Session::getUserID(),
			'hdt_worker' => '0',
			'hdt_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'hdt_title' => $form->getVar('title'),
			'hdt_other' => $form->getVar('other'),
			'hdt_priority' => '0',
			'hdt_status' => 'open',
			'hdt_options' => $options,
		));
		if (false === $ticket->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateCT();
		}
		$ticket->setVar('hdt_uid', GWF_Session::getUser());
		
		$message = new GWF_HelpdeskMsg(array(
			'hdm_id' => '0',
			'hdm_tid' => $ticket->getID(),
			'hdm_uid' => GWF_Session::getUserID(),
			'hdm_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'hdm_message' => $form->getVar('message'),
			'hdm_options' => '0',
		));
		if (false === $message->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateCT();
		}
		$message->setVar('hdm_uid', GWF_Session::getUser());
		
		$this->onMailTicket($ticket, $message);
		
		return $this->module->message('msg_created');
	}
	
	private function onMailTicket(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message)
	{
		$admin = GWF_Group::ADMIN;
		$staff = GWF_Group::STAFF;
		$staff = GDO::table('GWF_UserGroup')->selectColumn('DISTINCT(ug_userid)', "group_name='$admin' OR group_name='$staff'", '', array('group'));
		foreach ($staff as $userid)
		{
			if (false !== ($user = GWF_User::getByID($userid)))
			{
				$this->onMailTicketB($ticket, $message, $user);
			}
		}
	}
	
	private function onMailTicketB(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message, GWF_User $user)
	{
		if ('' === ($rec = $user->getValidMail())) {
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($this->module->langUser($user, 'subj_nt', array($ticket->getID())));
		$href_work = Common::getAbsoluteURL($this->module->getMethodURL('AssignWork', '&ticket='.$ticket->getID().'&worker='.$user->getID().'&token='.$ticket->getHashcode()), false);
		$mail->setBody($this->module->langUser($user, 'body_nt', array($user->displayUsername(), $ticket->getCreator()->displayUsername(), $ticket->displayTitle($user), $message->displayMessage(), $href_work)));
		return $mail->sendToUser($user);
	}
}
?>