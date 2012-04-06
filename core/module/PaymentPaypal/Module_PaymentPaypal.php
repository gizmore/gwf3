<?php
require_once GWF_CORE_PATH.'module/Payment/GWF_PaymentModule.php';
require_once 'Paypal_Util.php';

final class Module_PaymentPaypal extends GWF_PaymentModule
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	public function getClasses() { return array('Paypal_Util'); }
	public function onRequest() { $this->cfgDefineSettings(); return parent::onRequest(); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/paypal'); }
//	public function getDefaultAutoLoad() { return true; }
	
	public function onInstall($dropTable)
	{
		return parent::onInstall($dropTable).
			GWF_ModuleLoader::installVars($this, array(
				'PAYPAL_VERSION' => array('2.3', 'script'),
				'PAYPAL_API_USERNAME'  => array('CBusch1980_api1.gmx.de', 'text', 8, 128),
				'PAYPAL_API_PASSWORD'  => array('ECL83PUVR4CF2LU3', 'text', 16, 16),
				'PAYPAL_API_SIGNATURE' => array('An5ns1Kso7MWUdW4ErQKJJJ4qi4-AKKoQTrZVr51cIn6b.aMsI-4t2xg', 'text'),
				'PAYPAL_API_ENDPOINT'  => array('https://api-3t.sandbox.paypal.com/nvp', 'text'),
				'PAYPAL_URL'           => array('https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=', 'text'),
				'PAYPAL_USE_PROXY'  => array(false, 'bool'),
				'PAYPAL_PROXY_HOST' => array('127.0.0.1', 'text'),
				'PAYPAL_PROXY_PORT' => array('8080', 'int', 1, 65535),
			));
	}
	
	public function cfgDefineSettings()
	{
		if (!defined('PAYPAL_VERSION'))
		{
			define('PAYPAL_VERSION', $this->getModuleVar('PAYPAL_VERSION', '2.3'));
			define('PAYPAL_API_USERNAME', $this->getModuleVar('PAYPAL_API_USERNAME', 'CBusch1980_api1.gmx.de'));
			define('PAYPAL_API_PASSWORD', $this->getModuleVar('PAYPAL_API_PASSWORD', 'ECL83PUVR4CF2LU3'));
			define('PAYPAL_API_SIGNATURE', $this->getModuleVar('PAYPAL_API_SIGNATURE', 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AKKoQTrZVr51cIn6b.aMsI-4t2xg'));
			define('PAYPAL_API_ENDPOINT', $this->getModuleVar('PAYPAL_API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp'));
			define('PAYPAL_URL', $this->getModuleVar('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token='));
			define('PAYPAL_USE_PROXY', $this->getModuleVar('PAYPAL_USE_PROXY', false));
			define('PAYPAL_PROXY_HOST', $this->getModuleVar('PAYPAL_PROXY_HOST', '127.0.0.1'));
			define('PAYPAL_PROXY_PORT', $this->getModuleVar('PAYPAL_PROXY_PORT', '8080'));
		}
	}
	
	public function onStartup()
	{
		GWF_PaymentModule::registerPaymentModule($this);
		$this->cfgDefineSettings();
	}
	
	public function execute($methodname)
	{
		GWF_Module::loadModuleDB('Payment')->onInclude();
		return parent::execute($methodname);
	}
	
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return 'PayPal'; }
	public function getSiteNameToken() { return 'pp'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$tVars = array(
			'form_action' => GWF_WEB_ROOT.'index.php?mo=PaymentPaypal&me=InitCheckout',
			'img_path' => GWF_WEB_ROOT.'img/'.GWF_ICON_SET.'/buy_pp.png',
			'form_hidden' => $this->getHiddenData($module, $order, $gdo, $user),
		);
		return $this->templatePHP('paybutton.php', $tVars);
	}
	
	private function getHiddenData(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		return GWF_Form::hidden('gwf_token', $order->getOrderToken());
	}
	
	public function displayPaysiteButton3(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$tVars = array(
			'form_action' => GWF_WEB_ROOT.'index.php?mo=PaymentPaypal&me=ConfirmCheckout2',
			'img_path' => GWF_WEB_ROOT.'img/'.GWF_ICON_SET.'/buy_pp.png',
			'form_hidden' => $this->getHiddenData($module, $order, $gdo, $user),
		);
		return $this->templatePHP('paybutton.php', $tVars);
	}

}

?>
