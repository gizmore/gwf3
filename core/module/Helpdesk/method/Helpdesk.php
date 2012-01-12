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
		return $this->templateHelpdesk($this->_module);
	}
	
	private function templateHelpdesk()
	{
		$tVars = array(
			'href_new_ticket' => $this->_module->getMethodURL('CreateTicket'),
			'href_my_tickets' => $this->_module->getMethodURL('ShowTickets'),
			'href_staffdesk' => $this->_module->getMethodURL('Staff'),
			'href_faq' => $this->_module->getMethodURL('FAQ'),
			'ticketcount' => $this->getTicketCount($this->_module),
			'stafftickets' => $this->getTicketCountStaff($this->_module),
		);
		return $this->_module->template('helpdesk.tpl', $tVars);
	}
	
	private function getTicketCount()
	{
		$uid = GWF_Session::getUserID();
		$read = GWF_HelpdeskTicket::USER_READ;
		if (0 == ($c = GDO::table('GWF_HelpdeskTicket')->countRows("hdt_uid=$uid AND hdt_options&$read=0"))) {
			return '';
		}
		return "[$c]";
	}

	private function getTicketCountStaff()
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