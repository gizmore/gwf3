<?php
final class Helpdesk_Staff extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Helpdesk&me=Staff.php',
						'page_title' => 'Helpdesk Staff Page',
						'page_meta_desc' => 'Staff page for tickets editing',
				),
		);
	}
	
	public function execute()
	{
		return $this->templateStaff();
	}
	
	private function templateStaff()
	{
		$tickets = GDO::table('GWF_HelpdeskTicket');
		
		$limit = 25;
		$by = Common::getGetString('by', 'hdt_priority');
		$dir = Common::getGetString('dir', 'DESC');
		$orderby = $tickets->getMultiOrderby($by, $dir);
		
		$where = $this->getConditions();
		$mode = $this->getMode();
		$nItems = $tickets->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($limit, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $limit);
		
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Heldpdesk&me=Staff&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%&mode='.$mode),
			'tickets' => $tickets->selectAll('t.*, creator.user_name creator_name, worker.user_name worker_name', $where, $orderby, array('worker','creator'), $limit, $from, GDO::ARRAY_O),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Helpdesk&me=Staff&by=%BY%&dir=%DIR%&mode='.$mode,
			'href_all' => $this->getMethodHREF('&mode=all'),
			'href_own' => $this->getMethodHREF('&mode=own'),
			'href_open' => $this->getMethodHREF('&mode=open'),
			'href_work' => $this->getMethodHREF('&mode=work'),
			'href_closed' => $this->getMethodHREF('&mode=closed'),
			'href_unsolved' => $this->getMethodHREF('&mode=unsolved'),
		);
		return $this->module->template('staff.tpl', $tVars);
	}

	private function getMode()
	{
		$modes = array('own', 'open', 'work', 'closed', 'unsolved');
		$mode = Common::getGetString('mode');
		return in_array($mode, $modes, true) ? $mode : '';
	}
	
	private function getConditions()
	{
		switch (Common::getGetString('mode'))
		{
			case 'own':
				$uid = GWF_Session::getUserID();
				return "hdt_worker=$uid";
			case 'open':
				return "hdt_status='open'";
			case 'work':
				return "hdt_status='working'";
			case 'closed':
				return "hdt_status='solved'";
			case 'unsolved':
				return "hdt_status='unsolved'";
			default:
				return '';
		}
	}
}
?>