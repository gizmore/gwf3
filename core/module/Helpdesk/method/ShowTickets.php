<?php
final class Helpdesk_ShowTickets extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		return $this->templateTickets();
	}
	
	private function templateTickets()
	{
		$limit = 25;
		
		$uid = GWF_Session::getUserID();
		$tickets = GDO::table('GWF_HelpdeskTicket');
		$where = "hdt_uid=$uid";
		
		$by = Common::getGetString('by', 'hdt_date');
		$dir = Common::getGetString('dir', 'DESC');
		$orderby = $tickets->getMultiOrderby($by, $dir);
		
		$nItems = $tickets->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($limit, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $limit);
		
		$tVars = array(
			'tickets' => $tickets->selectAll('*, worker.user_name worker_name', $where, $orderby, array('worker'), $limit, $from, GDO::ARRAY_O),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Helpdesk&me=ShowTickets&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Helpdesk&me=ShowTickets&by=%BY%&dir=%DIR%',
		);
		return $this->module->template('user.tpl', $tVars);
	}
}
?>