<?php 
final class VersionServer_Purchase extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	private $modules;
	
	public function execute(GWF_Module $module)
	{
		if (false === ($mod_pay = GWF_Module::getModule('Payment'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Payment'));
		}
		
		// INIT
		$isAdmin = GWF_User::isAdminS();
		$modules = GWF_Module::loadModulesFS();
		foreach ($this->_modules as $i => $m)
		{
			if (!$isAdmin)
			{
				if ($m->getPrice() > 100000) {
					unset($this->_modules[$i]);
				}
			}
		}
		GWF_Module::sortModules($this->_modules, 'module_name', 'asc');
		
		$this->modules = $modules;
		// Modules to purchase
		
		if (false !== Common::getPost('on_order_2_x')) {
			return $this->onOrder($this->_module);
		}
		
		// Actions
		if (Common::getPost('purchase')) {
			return $this->onPurchase($this->_module);
		}
		
		if (false !== Common::getGet('zipper')) {
			return $this->onZip($this->_module);
		}
		
		
		return $this->templatePurchase($this->_module);
	}
	
	private function templatePurchase(Module_VersionServer $module)
	{
		$designs = GWF_Design::getDesigns();
		$langs = GWF_Language::getSupportedLanguages();
		
		$tVars = array(
			'modules' => $this->modules,
			'designs' => $designs,
			'langs' => $langs,
			'client' => GWF_Client::getByID(GWF_Session::getUserID()),
		);
		return $this->_module->templatePHP('purchase.php', $tVars);
	}
	
	private function onPurchase(Module_VersionServer $module)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return GWF_HTML::error('Purchase GWF Modules', $error).$this->templatePurchase($this->_module);
		}
		
		if ( (!(isset($_POST['mod']))) || (!is_array($_POST['mod'])) ) {
			return $this->_module->error('err_select_modules').$this->templatePurchase($this->_module);
//			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__)).$this->templatePurchase($this->_module);
		}
		 
		$purchased_modules = array();
		foreach ($_POST['mod'] as $mname => $yes)
		{
			if (isset($this->modules[$mname]))
			{
				$purchased_modules[] = $mname;
			}
		}
		if (count($purchased_modules) === 0) {
			return $this->_module->error('err_select_modules').$this->templatePurchase($this->_module);
		}
		
		$designs = GWF_Design::getDesigns();
		$purchased_designs = array();
		foreach ($_POST['design'] as $dname => $yes)
		{
			if (array_key_exists($dname, $designs))
			{
				$purchased_designs[] = $dname;
			}
		}
				
		$user = GWF_User::getStaticOrGuest();
		$userid = GWF_Session::getUserID();
		
		if (false === ($client = GWF_Client::getClient($userid))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templatePurchase($this->_module);
		}
		
		$order = new GWF_ClientOrder(array(
			'vsco_uid' => $userid,
			'vsco_modules' => implode(',', $purchased_modules),
			'vsco_designs' => implode(',', $purchased_designs),
		));
		
		Module_Payment::saveTempOrder($order);
		
		$tVars = array(
			'order' => Module_Payment::displayOrderS($this->_module, $order, $user),
		);
		
		return $this->_module->template('order.tpl', $tVars);
	}
	
	private function onZip(GWF_Module $module)
	{
		$client = GWF_Client::getClient(GWF_Session::getUserID());
		
		$rand = Common::randomDateStamp();
		$archivename = 'dbimg/gwf_purchase_'.$rand.'.zip';
		
		$zipper = $this->_module->getMethod('Zipper');
		$zipper instanceof VersionServer_Zipper;
		$zipper->setArchiveName($archivename);
		$error = $zipper->onZip($this->_module, $client->getModuleNames(), 'default');
		if ($zipper->hasError()) {
			return $error;
		}
		
		GWF_Upload::outputFile($archivename, 'arc/zip');
		
		return $error;
		
	}
	
	private function onOrder(GWF_Module $module)
	{
		// Check for Payment, as it`s not a required dependency.
		
//		var_dump(GWF_Session::getSessData());
		
		if (false === ($order = Module_Payment::getTempOrder())) {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__)).$this->templatePurchase($this->_module);
		}
		Module_Payment::dropTempOrder();
		
		$user = GWF_User::getStaticOrGuest();
		$paysite = Common::getPost('paysite', 'xx');
		
		return Module_Payment::displayOrder2S($this->_module, $order, $user, $paysite);
	}
	
}
?>
