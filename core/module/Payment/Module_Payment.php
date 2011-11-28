<?php
require_once 'GWF_PaymentModule.php';
/**
 * Module to administrate Payments.
 * @author gizmore
 * @version 1.00
 */
final class Module_Payment extends GWF_Module
{
	private static $instance;
	/**
	 * @return Module_Payment
	 */
	public static function instance() { return self::$instance; }
	
	# Temp Order
	const SESS_ORDER = 'GWF_ORDERS';
	
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 49.95; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/payment'); }
	public function getClasses() { return array('GWF_Currency', 'GWF_Order', 'GWF_ShoppingCart'); }
	public function getDefaultPriority() { return GWF_Module::DEFAULT_PRIORITY - 10; } # We might have deps
//	public function getDefaultAutoLoad() { return true; }
	public function onInstall($dropTable) { require_once 'install/GWF_PaymentInstall.php'; return GWF_PaymentInstall::install($this, $dropTable); }
	public function onCronjob() { require_once('install/GWF_PaymentCronjob.php'); return GWF_PaymentCronjob::onCronjob($this); }
	public function getAdminSectionURL() { return $this->getMethodURL('Staff'); }
	public function onStartup()
	{
		$this->onLoadLanguage();
		self::$instance = $this;
		$payment_modules = GDO::table('GWF_Module')->selectColumn('module_name', 'module_options&1 AND module_name like \'Payment%\'', 'module_priority ASC');
		foreach ($payment_modules as $modulename)
		{
			GWF_Module::loadModuleDB($modulename);
		}
//		$modules = GWF_Module::getModules();
//		foreach ($modules as $name => $module)
//		{
//			if (Common::startsWith($name, 'Payment') && is_array($module))
//			{
//				GWF_Module::getModule($name, true);
//			}
//		}
//		$this->onLoadLanguage();
	}
	
	##############
	### Config ###
	##############
	public function cfgDonations() { return $this->getModuleVarBool('donations', '1'); }
	public function cfgCurrency() { return $this->getModuleVar('currency', 'EUR'); }
	public function cfgCurrencies() { return explode(':', $this->getModuleVar('currencies', array('EUR:USD'))); }
//	public function cfgLocalFeeBuy() { return $this->getModuleVar('local_fee_buy', 1.0); }
//	public function cfgLocalFeeSell() { return $this->getModuleVar('local_fee_sell', 2.0); }
	public function cfgGlobalFeeBuy() { return (float)$this->getModuleVar('global_fee_buy', 4.0); }
	public function cfgGlobalFeeSell() { return (float)$this->getModuleVar('global_fee_sell', 8.0); }
	public function cfgOrdersPerPage() { return $this->getModuleVarInt('orders_per_page', 50); }
	
	###################
	### Convinience ###
	###################
	public static function displayPrice($price, $currency=true)
	{
		$currency = $currency === true ? self::getModule('Payment')->cfgCurrency() : $currency;
		require_once 'GWF_Currency.php';
		return GWF_Currency::getByISO($currency)->displayValue($price, true);
	}
	public static function getShopCurrencyS() { return self::getModule('Payment')->cfgCurrency(); }
	
	##################
	### Temp Order ###
	##################
	public static function saveTempOrder(GWF_Orderable $gdos)
	{
		GWF_Session::set(self::SESS_ORDER, serialize($gdos));
		return false; # no error
	}
	
	/**
	 * Get temp order from session or false.
	 * @return GWF_Orderable
	 */
	public static function getTempOrder()
	{
		if (false === ($object = GWF_Session::getOrDefault(self::SESS_ORDER, false))) {
			return false;
		}
		return unserialize($object);
	}

	public static function dropTempOrder()
	{
		GWF_Session::remove(self::SESS_ORDER);
	}
	
	#####################################
	### Step 1: Show Shopping Options ###
	#####################################
	public static function displayOrderActionsS(GWF_Module $module, GDO $gdo, GWF_User $user)
	{
		return self::getModule('Payment')->displayOrderActions($module, $gdo, $user);
	}
	
	public function displayOrderActions(GWF_Module $module, GDO $gdo, GWF_User $user)
	{
		if (!($gdo instanceof GWF_Orderable))
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		if (!($gdo->canOrder($user))) {
			return $this->error('err_can_order');
		}
		
		$this->onLoadLanguage();
		$price = $gdo->getOrderPrice($user);
		$fee_perc = $this->cfgGlobalFeeBuy();
		$fee = round($price * $fee_perc / 100, 2);
		$price_total = $price + $fee;
		
//		var_dump($price, $fee_perc, $fee, $price_total);
		
		$tVars = array(
			'order' => $gdo->displayOrder($module),
			'price' => self::displayPrice($price),
			'has_fee' => $fee > 0,
			'fee' => self::displayPrice($fee),
			'fee_percent' => sprintf('%0.2f%%', $fee_perc),
			'price_total' => self::displayPrice($price_total),
			'buttons' => self::displayOrderActionBtns(),
		);
		return $this->templatePHP('order.php', $tVars);
	}
	
	public static function displayOrderActionBtns()
	{
		return
			self::tinyForm('on_order_1', 'img/'.GWF_ICON_SET.'/coins.png').
			self::tinyForm('on_put_cart', 'img/'.GWF_ICON_SET.'/add.png').
			self::tinyForm('on_show_cart', 'img/'.GWF_ICON_SET.'/cart.png');
	}
	
	public static function tinyform($name, $src, $action=true, $hidden='')
	{
		$action = $action===true?GWF_HTML::display($_SERVER['REQUEST_URI']):$action;
		$inline = ' style="display:inline;" ';
		return sprintf('<div'.$inline.'><form'.$inline.'action="%s" method="post"><div'.$inline.'>%s<input'.$inline.'type="image" name="%s" src="%s" /></div></form></div>', $action, $hidden, $name, GWF_WEB_ROOT.$src);
	}
	
	####################################
	### Step 2: Show Payment Options ###
	####################################
	public static function displayOrderS(GWF_Module $module, GDO $gdo, GWF_User $user)
	{
		return self::getModule('Payment')->displayOrder($module, $gdo, $user);
	}
	
	public function displayOrder(GWF_Module $module, GDO $gdo, GWF_User $user)
	{
		if (!($gdo instanceof GWF_Orderable))
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		if (!($gdo->canOrder($user))) {
			return $this->error('err_can_order');
		}
		
		$this->onLoadLanguage();
		$price = $gdo->getOrderPrice($user);
		$fee_perc = $this->cfgGlobalFeeBuy();
		$fee = round($price * $fee_perc / 100, 2);
		$price_total = $price + $fee;
		
		$tVars = array(
			'order' => $gdo->displayOrder($module),
			'price' => self::displayPrice($price),
			'fee' => self::displayPrice($fee),
			'has_fee' => $fee > 0,
			'fee_percent' => sprintf('%0.2f%%', $fee_perc),
			'price_total' => self::displayPrice($price_total),
			'buttons' => GWF_PaymentModule::displayPaymentButtons($gdo, $price_total),
		);
		return $this->templatePHP('order.php', $tVars);
	}
	
	#############################
	### Step 3: Chose Payment ###
	#############################
	public static function displayOrder2S(GWF_Module $module, GDO $gdo, GWF_User $user, $sitename)
	{
		return self::getModule('Payment')->displayOrder2($module, $gdo, $user, $sitename);
	}
	
	public function displayOrder2(GWF_Module $module, GDO $gdo, GWF_User $user, $sitename)
	{
		if (!($gdo instanceof GWF_Orderable))
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		if (!($gdo->canOrder($user))) {
			return $this->error('err_can_order');
		}
		
		if (false === ($paysite = GWF_PaymentModule::getPaymentModule($sitename))) {
			return $this->error('err_paysite');
		}
		
		$paysite->onLoadLanguage();
		
		$this->onLoadLanguage();
		$price = $gdo->getOrderPrice($user);
		$fee_perc = round($this->cfgGlobalFeeBuy() + $paysite->cfgSiteFeeBuy(), 2);
		$fee = round($price * $fee_perc / 100, 2);
		$price_total = $price + $fee;
		
		
		# Insert the order
		require_once 'GWF_Order.php';
		if (false === ($order = GWF_Order::insertOrder($module, $gdo, $paysite, $user, $price_total))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		
		$tVars = array(
			'order' => $gdo->displayOrder($module),
			'price' => self::displayPrice($price), # $gdo-> getOrderPrice($user),
			
			'fee' => self::displayPrice($fee),
			'has_fee' => $fee > 0,
			'fee_percent' => sprintf('%0.2f%%', $fee_perc),
			'price_total' => self::displayPrice($price_total),

			'buttons' => $paysite->displayPaysiteButton($module, $order, $gdo, $user),
		
			'paymodule_info' => $paysite->lang('paymodule_info2'),
		);
		
		return $this->templatePHP('order.php', $tVars);
	}
	
	###############################
	### Step 4: Sent to Paysite ###
	###############################
//	public static function onSendToPaysiteS(GWF_Module $module)
//	{
//		return self::getModule('Payment')->onSendToPaysite($module);
//	}
//	
//	public function onSendToPaysite(GWF_Module $module)
//	{
//		if (false === ($token = Common::getPost('gwf_order'))) {
//			return $this->error('err_order');
//		}
//		
//		if (false === ($order = GWF_Order::getByToken($token))) {
//			return $this->error('err_order');
//		}
//		
//	}
	
	################################
	### Step X: Show order again ###
	################################
	public static function displayOrder3S(GWF_Module $module, GWF_Order $order, GDO $gdo, GWF_User $user, $sitename, $buttons)
	{
		return self::instance()->displayOrder3($module, $order, $gdo, $user, $sitename, $buttons);
	}
	public function displayOrder3(GWF_Module $module, GWF_Order $order, GDO $gdo, GWF_User $user, $sitename, $buttons)
	{
		if (false === ($paysite = GWF_PaymentModule::getPaymentModule($sitename))) {
			return $this->error('err_paysite');
		}
		
		$paysite->onLoadLanguage();
		$this->onLoadLanguage();
		$fee = $order->getOrderFee();
		$fee_perc = $order->getOrderFeePercent();
		$tVars = array(
			'order' => $gdo->displayOrder($module),
			'price' => self::displayPrice($order->getOrderPrice()), # $gdo-> getOrderPrice($user),
			
			'fee' => self::displayPrice($fee),
			'has_fee' => $fee > 0,
			'fee_percent' => sprintf('%.02f%%', $fee_perc),
			'price_total' => self::displayPrice($order->getOrderPriceTotal()),
			'no_info' => true,

			'buttons' => $buttons,
		
			'paymodule_info' => $paysite->lang('paymodule_info3'),
		);
		return $this->templatePHP('order.php', $tVars);
	}
	
	##################
	### On Execute ###
	##################
	public static function onExecuteOrderS(GWF_Module $module, GWF_Order $order)
	{
		$mod_pay = Module_Payment::instance();
		if (false === self::instance()->onExecuteOrder($module, $order)) {
			return $mod_pay->error('err_crit', $order->getOrderToken());
		}
		return $mod_pay->message('msg_paid');
	}
	
	public function onExecuteOrder(GWF_Module $module, GWF_Order $order)
	{
//		if (false === $order->saveVar('order_status', GWF_Order::PAID)) {
//			return $this->logCriticalError($module, $order);
//		}
		
		if (false === ($order->execute())) {
			return $this->logCriticalError($module, $order);
		}
		
//		if (false === $order->saveVar('order_status', GWF_Order::PROCESSED)) {
//			return $this->logCriticalError($module, $order);
//		}
		
		return $this->message('msg_paid');
	}
	
	public function onPendingOrder(GWF_Module $module, GWF_Order $order)
	{
		return $this->message('msg_pending');
	}
	
	
	private function logCriticalError(GWF_Module $module, GWF_Order $order)
	{
		$message = $this->error('err_crit', $order->getOrderToken());
		GWF_Log::logCritical($message);
		GWF_Website::addDefaultOutput($message);
		return '';
	}
	
	################
	### Donation ###
	################
	public static function displayDonateButton()
	{
		
	}
}

?>
