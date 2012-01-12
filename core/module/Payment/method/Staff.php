<?php

final class Payment_Staff extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	
	public function execute()
	{
		if (false !== (Common::getPost('qsearch'))) {
			return $this->onQuickSearch($this->_module);
		}
		
		return $this->templateStaff($this->_module);
	}
	
	### Search Templates
	public function templateAdvSearch() { return GWF_FormGDO::getSearchForm($this->_module, $this, GDO::table('GWF_Order'), GWF_Session::getUser()); }
	public function templateQuickSearch() { return GWF_FormGDO::getQuickSearchForm($this->_module, $this, GDO::table('GWF_Order'), GWF_Session::getUser()); }

	private function getTable()
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
		return GWF_Table::displayGDO2($this->_module, $orders, GWF_Session::getUser(), $sortURL, $conditions, 25, true);
	}
	
	public function templateStaff()
	{
		$tVars = array(
			'quicksearch' => $this->templateQuickSearch($this->_module)->templateX($this->_module->lang('ft_search')),
			'table' => $this->getTable($this->_module),
			'href_orders' => $this->getMethodHref(sprintf('&o=1&by=order_id&dir=DESC&page=1')),
			'href_transactions' => $this->getMethodHref(sprintf('&t=1&by=order_id&dir=DESC&page=1')),
		);
		return $this->_module->templatePHP('staff.php', $tVars);
	}
	
	private function onQuickSearch()
	{
		$tVars = array(
			'quicksearch' => $this->templateQuickSearch($this->_module)->templateX($this->_module->lang('ft_search')),
			'table' => $this->getQuickSearchTable($this->_module),
			'href_orders' => $this->getMethodHref(sprintf('&o=1&by=order_id&dir=DESC&page=1')),
			'href_transactions' => $this->getMethodHref(sprintf('&t=1&by=order_id&dir=DESC&page=1')),
		);
		return $this->_module->templatePHP('staff.php', $tVars);
	}
	
	private function getQuickSearchTable()
	{
		$user = GWF_User::getStaticOrGuest();
		$orders = GDO::table('GWF_Order');

		$o = Common::getGet('o') !== false;
		$bit = $o ? 'o' : 't';
		$sortURL = $this->getMethodHref('&'.$bit.'=1&by=%BY%&dir=%DIR%');
		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($orders, $orders->getSearchableFields($user), Common::getRequest('term'))))
		{
			$conditions = '0';
		}
//		var_dump($conditions);
		return GWF_Table::displayGDO2($this->_module, $orders, $user, $sortURL, $conditions, 25, true);
	}
}

?>