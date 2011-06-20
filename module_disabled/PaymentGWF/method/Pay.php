<?php
final class PaymentGWF_Pay extends GWF_Method
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
		
		return $this->templatePay($module, $order);
	}
	
	private function templatePay(Module_PaymentGWF $module, GWF_Order $order)
	{
		$module2 = $order->getOrderModule();
		$module2->onLoadLanguage();
		$gdo = $order->getOrderData();
		$user = $order->getUser();
		$sitename = $module->getSiteName();
		
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentGWF&me=Pay2';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		$buttons = Module_Payment::tinyform('BUYGWF', 'img/'.GWF_ICON_SET.'buy_gwf.gif', $action, $hidden);

		$lang = $module->loadLangGWF();
		
		if (false !== ($error = $module->canAffordB($order, $user))) {
			return $error;
		}
		
		$tVars = array(
			'lang' => $lang,
			'user' => $user,
			'order' => Module_Payment::displayOrder3S($module2, $order, $gdo, $user, $sitename, $buttons),
		);
		return $module->templatePHP('pay.php', $tVars);
	}
}
?>