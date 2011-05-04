<?php
final class Helpdesk_Helpdesk extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^helpdesk/?$ index.php?mo=Helpdesk&me=Helpdesk'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateHelpdesk($module);
	}
	
	private function templateHelpdesk(Module_Helpdesk $module)
	{
		$tVars = array(
			'href_new_ticket' => $module->getMethodURL('CreateTicket'),
			'href_my_tickets' => $module->getMethodURL('ShowTickets'),
			'href_staffdesk' => $module->getMethodURL('Staff'),
			'href_faq' => $module->getMethodURL('FAQ'),
			'ticketcount' => $this->getTicketCount($module),
			'stafftickets' => $this->getTicketCountStaff($module),
			'user' => GWF_User::getStaticOrGuest(),
		);
		return $module->template('helpdesk.tpl', $tVars);
	}
	
	private function getTicketCount(Module_Helpdesk $module)
	{
		$uid = GWF_Session::getUserID();
		$read = GWF_HelpdeskTicket::USER_READ;
		if (0 == ($c = GDO::table('GWF_HelpdeskTicket')->countRows("hdt_uid=$uid AND hdt_options&$read=0"))) {
			return '';
		}
		return "[$c]";
	}

	private function getTicketCountStaff(Module_Helpdesk $module)
	{
		$uid = GWF_Session::getUserID();
		$read = GWF_HelpdeskTicket::STAFF_READ;
		if (0 == ($c = GDO::table('GWF_HelpdeskTicket')->countRows("hdt_worker=$uid AND hdt_options&$read=0"))) {
			return '';
		}
		return "[$c]";
	}
}
?>