<?php
final class Helpdesk_CreateTicket extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		require_once 'core/module/Helpdesk/GWF_HelpdeskTitle.php';
		
		if (false !== Common::getPost('create')) {
			return $this->onCreate($module);
		}
		
		return $this->templateCT($module);
	}
	
	private function templateCT(Module_Helpdesk $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_new_ticket')),
		);
		return $module->template('new_ticket.tpl', $tVars);
	}
	
	private function getForm(Module_Helpdesk $module)
	{
		$data = array(
			'title' => array(GWF_Form::SELECT, GWF_HelpdeskTitle::select('title', Common::getPostString('title')), $module->lang('th_title')),
			'other' => array(GWF_Form::STRING, '', $module->lang('th_other')),
			'message' => array(GWF_Form::MESSAGE, '', $module->lang('th_message')),
			'faq' => array(GWF_Form::CHECKBOX, false, $module->lang('th_allow_faq'), $module->lang('tt_allow_faq')),
			'email' => array(GWF_Form::CHECKBOX, true, $module->lang('th_email_me')),
			'create' => array(GWF_Form::SUBMIT, $module->lang('btn_new_ticket')),
		);
		return new GWF_Form($this, $data);
	}
	
    public function validate_title($m, $arg) { return GWF_HelpdeskTitle::validate_title($m, $arg); } 
    public function validate_other($m, $arg) { return false; }
    public function validate_message($m, $arg) { return $m->validate_message($arg); }
	
	private function onCreate(Module_Helpdesk $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateCT($module);
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
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateCT($module);
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
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateCT($module);
		}
		$message->setVar('hdm_uid', GWF_Session::getUser());
		
		$this->onMailTicket($module, $ticket, $message);
		
		return $module->message('msg_created');
	}
	
	private function onMailTicket(Module_Helpdesk $module, GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message)
	{
		$admin = GWF_Group::ADMIN;
		$staff = GWF_Group::STAFF;
		$staff = GDO::table('GWF_UserGroup')->selectColumn('DISTINCT(ug_userid)', "group_name='$admin' OR group_name='$staff'", '', array('group'));
		foreach ($staff as $userid)
		{
			if (false !== ($user = GWF_User::getByID($userid)))
			{
				$this->onMailTicketB($module, $ticket, $message, $user);
			}
		}
	}
	
	private function onMailTicketB(Module_Helpdesk $module, GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message, GWF_User $user)
	{
		if ('' === ($rec = $user->getValidMail())) {
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($module->langUser($user, 'subj_nt', array($ticket->getID())));
		$href_work = Common::getAbsoluteURL($module->getMethodURL('AssignWork', '&ticket='.$ticket->getID().'&worker='.$user->getID().'&token='.$ticket->getHashcode()), false);
		$mail->setBody($module->langUser($user, 'body_nt', array($user->displayUsername(), $ticket->getCreator()->displayUsername(), $ticket->displayTitle($user), $message->displayMessage(), $href_work)));
		return $mail->sendToUser($user);
	}
}
?>