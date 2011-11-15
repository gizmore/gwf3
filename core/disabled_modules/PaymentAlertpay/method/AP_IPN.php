<?php
final class PaymentAlertpay_AP_IPN extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$data = '';
		foreach ($_POST as $key => $value) { $data .= "$key: $value\n"; }
		GWF_Log::log('alertpay', $data);

		return $this->ipn($module);
	}
	
	private function ipn(Module_PaymentAlertpay $module)
	{
		if (Common::getPost("ap_securitycode") !== $module->cfgSecCode()) {
			GWF_Log::log('alertpay', 'Invalid alertpay security code');
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false === ($email = Common::getPost("ap_custemailaddress"))) {
			GWF_Log::log('alertpay', 'Missing ap_custemailaddress');
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (Common::getPost("ap_status") !== "Success") {
			GWF_Log::log('alertpay', 'Alertpay post was not success');
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false === ($token = Common::getPost("ap_itemcode"))) {
			GWF_Log::log('alertpay', 'Missing ap_itemcode');
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
	
		if (false === ($order = GWF_Order::getByToken($token))) {
			GWF_Log::log('alertpay', 'Order not found or token invalid: '.$token);
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		if (!$order->isCreated()) {
			return $module->error('err_order');
		}
		
		if (false === ($price = (float)Common::getPost('ap_amount'))) {
			GWF_Log::log('alertpay', 'MISSING ap_amount for '.$token);
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if ($price !== (float) $order->getOrderPriceTotal()) {
			GWF_Log::log('alertpay', 'The price for the orders is not the same: '.$token);
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		$order->saveVar('order_email', $email);
		
		$module2 = $order->getOrderModule();
		$module2->onLoadLanguage();
		return Module_Payment::onExecuteOrderS($module2, $order);
	}
}
?>
