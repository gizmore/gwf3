<?php
final class Helpdesk_MarkRead extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false === ($ticket = GWF_HelpdeskTicket::getByID(Common::getGetString('ticket')))) {
			return $module->error('err_ticket');
		}
		
		if (false === ($message = GWF_HelpdeskMsg::getByID(Common::getGetString('message')))) {
			return $module->error('err_tmsg');
		}
		
		if ($message->getHashcode() !== Common::getGetString('token')) {
			return $module->error('err_token');
		}
		
		return $this->onMarkRead($module, $ticket, $message);
	}
	
	public function onMarkRead(Module_Helpdesk $module, GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message)
	{
		if (false === $message->saveOption(GWF_HelpdeskMsg::READ, true)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$bit = 0;
		if (GWF_Session::getUserID() === $ticket->getWorkerID()) {
			$bit |= GWF_HelpdeskTicket::STAFF_READ;
		}
		if (GWF_Session::getUserID() === $ticket->getCreatorID()) {
			$bit |= GWF_HelpdeskTicket::USER_READ;
		}
		
		if (false === $ticket->saveOption($bit, true)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_read');
	}
}
?>