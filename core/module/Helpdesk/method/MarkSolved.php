<?php
final class Helpdesk_MarkSolved extends GWF_Method
{
	public function execute()
	{
		if (false === ($ticket = GWF_HelpdeskTicket::getByID(Common::getGetString('ticket')))) {
			return $this->module->error('err_ticket');
		}
		
		if (false === ($message = GWF_HelpdeskMsg::getByID(Common::getGetString('message')))) {
			return $this->module->error('err_tmsg');
		}
		
		if ($message->getHashcode() !== Common::getGetString('token')) {
			return $this->module->error('err_token');
		}
		
		return $this->onMarkSolved($ticket, $message);
	}
	
	public function onMarkSolved(GWF_HelpdeskTicket $ticket, GWF_HelpdeskMsg $message)
	{
		if (false === $ticket->saveVars(array(
			'hdt_status' => 'solved',
		))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->module->message('msg_solve_solved');
	}
}
?>