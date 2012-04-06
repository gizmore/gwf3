<?php
final class GWF_ClientOrder extends GDO implements GWF_Orderable
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }	
	public function getTableName() { return GWF_TABLE_PREFIX.'vs_client_order'; }
	public function getColumnDefines()
	{
		return array(
			'vsco_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL), # userid for quick access
			'vsco_modules' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S), # purchased modules (Account,Register,..)
			'vsco_designs' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S), # purchased designs (default, gwf, wc, wc4...)
		);
	}
	
	public function getClient()
	{
		return GWF_Client::getByID($this->getVar('vsco_uid'));
	}
	
	###############
	### Modules ###
	###############
	public function getModuleNames()
	{
		return explode(',', $this->getVar('vsco_modules'));
	}
	
	public function getDesignNames()
	{
		return explode(',', $this->getVar('vsco_designs'));
	}
	
	public function getModules()
	{
		$mods = GWF_Module::loadModulesFS();
		$back = array();
		foreach ($this->getModuleNames() as $name)
		{
			if (isset($mods[$name]))
			{
				$back[] = $mods[$name];
			}
		}
		return $back;
	}
	
	public function getDesigns()
	{
		$have = $this->getDesignNames();
		$designs = GWF_Design::getDesigns();
		$back = array();
		
		foreach ($have as $design)
		{
			if (isset($designs[$design]))
			{
				$back[$design] = GWF_Design::getPrice($design);
			}
		}
		
		return $back;
		
	}
	
	#################
	### GWF_Order ###
	#################
	public function canOrder(GWF_User $user) { return $user->getID() > 0; }
	public function canRefund(GWF_User $user) { return true; }
	public function canPayWithGWF(GWF_User $user) { return true; }
	public function canAutomizeExec(GWF_User $user) { return true; }
	public function needsShipping(GWF_User $user) { return false; }

	public function getOrderWidth() { return 0.0; }
	public function getOrderHeight() { return 0.0; }
	public function getOrderDepth() { return 0.0; }
	public function getOrderWeight() { return 0.0; }
	
	public function getOrderModuleName() { return 'VersionServer'; }
	public function getOrderPrice(GWF_User $user)
	{
		$client = GWF_Client::getByID($user->getID());
		$have_mods = $client->getModuleNames();
		$new_mods = $this->getModules();
		$price = 0;
		foreach($new_mods as $mod)
		{
			$name = $mod->getName();
			if (!in_array($name, $have_mods, true))
			{
				$price += $mod->getPrice();
			}
		}
		
		$have_designs = $client->getDesignNames();
		$new_designs = $this->getDesignNames();
		$designs = GWF_Design::getDesigns();
		
		foreach ($new_designs as $design)
		{
			if (!in_array($design, $have_designs, true))
			{
				$price += $designs[$design];
			}
		}
		
		return $price;
		
	}
	public function getOrderItemName(GWF_Module $module, $lang_iso) { return $module->lang('order_title'); }
	public function getOrderDescr(GWF_Module $module, $lang_iso) { return $module->lang('order_descr'); }
	public function getOrderStock(GWF_User $user) { return 1; }
	public function getOrderCancelURL(GWF_User $user) { return GWF_WEB_ROOT.'index.php?mo=VersionServer&me=Purchase'; }
	public function getOrderSuccessURL(GWF_User $user) { return GWF_WEB_ROOT.'index.php?mo=VersionServer&me=Purchase'; }
	
	public function displayOrder(GWF_Module $module)
	{
		$tVars = array(
			'client' => $this->getClient(),
			'designs' => $this->getDesigns(),
			'modules' => $this->getModules(),
		);
		return $module->templatePHP('_order.php', $tVars);
	}
	
	public function executeOrder(GWF_Module $module, GWF_User $user)
	{
		$client = $this->getClient();
		if (false === $client->mergeModules($this->getModuleNames())) {
			return false;
		}
		if (false === $client->mergeDesigns($this->getDesignNames())) {
			return false;
		}
		
		$module->message('msg_purchased', array($client->getVar('vsc_token')), true, true);
		
		return true;
	} 
	
}
?>