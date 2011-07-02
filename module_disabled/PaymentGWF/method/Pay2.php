<?php
final class PaymentGWF_Pay2 extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($order = GWF_Order::getByToken(Common::getPost('gwf_token')))) {
			return $module->error('err_order');
		}
		
		if (!$order->isCreated()) {
			return $module->error('err_order');
		}
		
		return $this->onPay($module, $order);
	}
	
	private function onPay(Module_PaymentGWF $module, GWF_Order $order)
	{
		$module2 = $order->getOrderModule();
		$module2->onLoadLanguage();
		$gdo = $order->getOrderData();
		$user = $order->getUser();
		$sitename = $module->getSiteName();
		
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentGWF&me=Pay2';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		$buttons = Module_Payment::tinyform('BUYGWF', 'img/'.GWF_ICON_SET.'buy_gwf.png', $action, $hidden);

		$lang = $module->loadLangGWF();
		
		if (false !== ($error = $module->canAffordB($order, $user))) {
			return $error;
		}
		
		if (!$user->isAdmin())
		{
			if (false === $user->increase('user_credits', -$order->getOrderPriceTotal())) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		return Module_Payment::onExecuteOrderS($module2, $order);
	}
}
?>