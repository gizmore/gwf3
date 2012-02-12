<?php
/**
 * Assign a worker to a ticket, by email.
 * @author gizmore
 */
final class Helpdesk_AssignWork extends GWF_Method
{
	public function execute()
	{
		if (false === ($ticket = GWF_HelpdeskTicket::getByID(Common::getGetString('ticket')))) {
			return $this->module->error('err_ticket');
		}
		
		if (false === ($user = GWF_User::getByID(Common::getGetString('worker')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$user->loadGroups();
		if ( (!$user->isAdmin()) && (!$user->isStaff()) ) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (!$ticket->isOpen()) {
			return $this->module->error('err_not_open');
		}
		
		if ($ticket->getHashcode() !== Common::getGetString('token')) {
			return $this->module->error('err_token');
		}
		
		return $this->onAssign($ticket, $user);
	}
	
	public function onAssign(GWF_HelpdeskTicket $ticket, GWF_User $user)
	{
		if (false === $ticket->saveVars(array(
			'hdt_worker' => $user->getID(),
			'hdt_status' => 'working'
		))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_assigned', array($ticket->getID(), $user->displayUsername()));
	}
}
?>