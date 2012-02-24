<?php
final class Helpdesk_Helpdesk extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^helpdesk/?$ index.php?mo=Helpdesk&me=Helpdesk'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'helpdesk',
						'page_title' => 'Helpdesk',
						'page_meta_desc' => GWF_SITENAME.' Helpdesk',
				),
		);
	}
	
	public function execute()
	{
		return $this->templateHelpdesk();
	}
	
	private function templateHelpdesk()
	{
		$tVars = array(
			'href_new_ticket' => $this->module->getMethodURL('CreateTicket'),
			'href_my_tickets' => $this->module->getMethodURL('ShowTickets'),
			'href_staffdesk' => $this->module->getMethodURL('Staff'),
			'href_faq' => $this->module->getMethodURL('FAQ'),
			'ticketcount' => $this->getTicketCount(),
			'stafftickets' => $this->getTicketCountStaff(),
		);
		return $this->module->template('helpdesk.tpl', $tVars);
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