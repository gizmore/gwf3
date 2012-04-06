<?php
/**
 * Generic Payment Module.
 * You need to inherit this to create a new full featured payment module.
 * @author gizmore
 */
abstract class GWF_PaymentModule extends GWF_Module
{
	################
	### Abstract ###
	################
	public abstract function getSiteName();
	public abstract function getSiteNameToken();
	public abstract function getSupportedCurrencies();
	public abstract function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user);
	public function canAfford($user, $price) { return $price > 0; }
	
	##################
	### GWF_Module ###
	##################
//	public function getDefaultAutoLoad() { return true; }
	public function getDefaultPriority() { return GWF_Module::DEFAULT_PRIORITY + 1; } # Start at least one later
	public function getDependencies() { return array('Payment'=>1.00); }
	public function onInstall($dropTable)
	{
		return
			GWF_ModuleLoader::installVars($this, array(
				'fee_buy' => array('1.00', 'float', '-50', '50'),
				'fee_sell' => array('2.00', 'float', '-50', '50'),
			));
	}
	public function cfgSiteFeeBuy() { return (float)$this->getModuleVar('fee_buy', '1.00'); }
	public function cfgSiteFeeSell() { return (float)$this->getModuleVar('fee_sell', '2.00'); }
	
//	public function onStartup()
//	{
//		if (false !== ($mod_payment = self::getModule('Payment'))) {
//			$mod_payment->onInclude();
//		}
//		self::registerPaymentModule($this);
//	}
//	
//	
//	public function onRequest()
//	{
//		require_once 'GWF_Order.php';
//		return parent::onRequest();
//	}
	
//	public function onLoadLanguage()
//	{
//		return Module_Payment::instance()->onLoadLanguage();
//	}
	
	#####################
	### Accessability ###
	#####################
	private static $payment_modules = array();
	
	public static function registerPaymentModule(GWF_PaymentModule $module)
	{
		self::$payment_modules[$module->getSiteNameToken()] = $module;
	}
	
	/**
	 * @param string $sitename_token (2 or 3 chars)
	 * @return GWF_PaymentModule
	 */
	public static function getPaymentModule($sitename_token)
	{
		return isset(self::$payment_modules[$sitename_token]) ? self::$payment_modules[$sitename_token] : false;
	}
	
	public static function displayPaymentButtons(GWF_Orderable $gdo, $price_total)
	{
		$user = GWF_Session::getUser();
		$back = '';
		foreach (self::$payment_modules as $module)
		{
			#$module instanceof GWF_PaymentModule;
			if (!$module->canAfford($user, $price_total)) {
				continue;
			}
			$back .= self::displayPaymentButton($module);
		}
		return $back;
	}
	
	public static function displayPaymentButton(GWF_PaymentModule $module, $mode='2', $order_token=false)
	{
		$i = ' style="display:inline;" ';
		$token = $module->getSiteNameToken();
		$action = GWF_HTML::display($_SERVER['REQUEST_URI']);
		$hidden = GWF_Form::hidden('paysite', $token);
		$hidden .= $order_token === false ? '' : GWF_Form::hidden('gwf_order', $order_token);
		$button = GWF_Form::buttonImage('on_order_'.$mode, sprintf('img/'.GWF_ICON_SET.'/buy_%s.png', $token));
		return sprintf('<div%s><form%saction="%s" method="post"><div%s>%s%s</div></form></div>', $i, $i, $action, $i, $hidden, $button);
	}
}

?>
