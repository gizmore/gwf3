<?php

final class Payment_Staff extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('qsearch'))) {
			return $this->onQuickSearch($module);
		}
		
		return $this->templateStaff($module);
	}
	
	### Search Templates
	public function templateAdvSearch(Module_Payment $module) { return GWF_FormGDO::getSearchForm($module, $this, GDO::table('GWF_Order'), GWF_Session::getUser()); }
	public function templateQuickSearch(Module_Payment $module) { return GWF_FormGDO::getQuickSearchForm($module, $this, GDO::table('GWF_Order'), GWF_Session::getUser()); }

	private function getTable(Module_Payment $module)
	{
		$orders = GDO::table('GWF_Order'); 
		$paid = GWF_Order::PAID;
		$exec = GWF_Order::PROCESSED;
		$o = Common::getGet('o') !== false;
		$op = $o ? '!=' : '='; 
		$op2 = $o ? 'AND' : 'OR';
		$conditions = "(order_status$op'$paid' $op2 order_status$op'$exec')";
		$bit = $o ? 'o' : 't';
		$sortURL = $this->getMethodHref('&'.$bit.'=1&by=%BY%&dir=%DIR%');
		return GWF_Table::displayGDO2($module, $orders, GWF_Session::getUser(), $sortURL, $conditions, 25, true);
	}
	
	public function templateStaff(Module_Payment $module)
	{
		$tVars = array(
			'quicksearch' => $this->templateQuickSearch($module)->templateX($module->lang('ft_search')),
			'table' => $this->getTable($module),
			'href_orders' => $this->getMethodHref(sprintf('&o=1&by=order_id&dir=DESC&page=1')),
			'href_transactions' => $this->getMethodHref(sprintf('&t=1&by=order_id&dir=DESC&page=1')),
		);
		return $module->templatePHP('staff.php', $tVars);
	}
	
	private function onQuickSearch(Module_Payment $module)
	{
		$tVars = array(
			'quicksearch' => $this->templateQuickSearch($module)->templateX($module->lang('ft_search')),
			'table' => $this->getQuickSearchTable($module),
			'href_orders' => $this->getMethodHref(sprintf('&o=1&by=order_id&dir=DESC&page=1')),
			'href_transactions' => $this->getMethodHref(sprintf('&t=1&by=order_id&dir=DESC&page=1')),
		);
		return $module->templatePHP('staff.php', $tVars);
	}
	
	private function getQuickSearchTable(Module_Payment $module)
	{
		$user = GWF_User::getStaticOrGuest();
		$orders = GDO::table('GWF_Order');

		$o = Common::getGet('o') !== false;
		$bit = $o ? 'o' : 't';
		$sortURL = $this->getMethodHref('&'.$bit.'=1&by=%BY%&dir=%DIR%');
		$conditions = GWF_QuickSearch::getQuickSearchConditions($orders, $orders->getSearchableFields($user), Common::getRequest('term'));
//		var_dump($conditions);
		return GWF_Table::displayGDO2($module, $orders, $user, $sortURL, $conditions, 25, true);
	}
}

?>