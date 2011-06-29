<?php
require_once 'module/Payment/GWF_PaymentModule.php';

# CBusch1980@gmx.de
# 9Kt1NjFGlhGKlPvc

final class Module_PaymentAlertpay extends GWF_PaymentModule
{
	const SEND_MONEY_URL = 'https://api.alertpay.com/svc/api.svc/sendmoney';
	const RECEIVE_MONEY_URL = 'https://www.alertpay.com/PayProcess.aspx';
	
	##################
	### GWF_Module ###
	##################
	public function onLoadLanguage() { return $this->loadLanguage('lang/ap'); }
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	public function onInstall($dropTable)
	{
		return
			parent::onInstall($dropTable).
			$this->installVars(array(
				'ap_seller' => array(GWF_ADMIN_EMAIL, 'text', '6', GWF_User::EMAIL_LENGTH),
				'ap_sec_code' => array('1234567890abcdef', 'text', '16', '16'),
				'ap_send_code' => array('1234567890abcdef', 'text', '16', '16'),
				'ap_test_mode' => array('YES', 'bool'),
			));
	}
	public function cfgSeller() { return $this->getModuleVar('ap_seller', GWF_ADMIN_EMAIL); }
	public function cfgSecCode() { return $this->getModuleVar('ap_sec_code', '1234567890abcdef'); }
	public function cfgSendCode() { return $this->getModuleVar('ap_send_code', '1234567890abcdef'); }
	public function cfgTestMode() { return $this->getModuleVar('ap_test_mode', true); }
	
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return 'Alertpay'; }
	public function getSiteNameToken() { return 'ap'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$lang_iso = GWF_Language::getCurrentISO();
		$action = self::RECEIVE_MONEY_URL;
		
		$hidden = 
			GWF_Form::hidden('ap_purchasetype', 'item').
			GWF_Form::hidden('ap_merchant', $this->cfgSeller()).
			GWF_Form::hidden('ap_itemname', $gdo->getOrderItemName($module, $lang_iso)).
			GWF_Form::hidden('ap_currency', $order->getOrderCurrency()).
			GWF_Form::hidden('ap_returnurl', Common::getAbsoluteURL($gdo->getOrderSuccessURL($user), false)).
			GWF_Form::hidden('ap_itemcode', $order->getOrderToken()).
			GWF_Form::hidden('ap_quantity', $order->getOrderAmount()).
			GWF_Form::hidden('ap_description', $gdo->getOrderDescr($module, $lang_iso)).
			GWF_Form::hidden('ap_amount', $order->getOrderPriceTotal()).
			GWF_Form::hidden('ap_cancelurl', Common::getAbsoluteURL($gdo->getOrderCancelURL($user), false));
			
//		echo GWF_HTML::display($hidden);
		return Module_Payment::tinyform('pay_ap', 'img/'.GWF_ICON_SET.'buy_ap.png', $action, $hidden);
	}
	
	

}

?>
