<?php
final class PaymentBank_Pay2 extends GWF_Method
{
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
	
	private function templatePay(Module_PaymentBank $module, GWF_Order $order)
	{
		if (false === $order->saveVar('order_status', GWF_Order::ORDERED)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$tVars = array(
			'lang' => $module->loadLangGWF(),
			'order_c' => $order,
		);
		return $module->templatePHP('pay2.php', $tVars);
//		
//		$module2 = $order->getOrderModule();
//		$module2->onLoadLanguage();
//		$gdo = $order->getOrderData();
//		$user = $order->getUser();
//		$sitename = $module->getSiteName();
//		
//		$action = GWF_WEB_ROOT.'index.php?mo=PaymentBank&me=Pay2';
//		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
//		$buttons = Module_Payment::tinyform('Bank Transfer', 'img/'.GWF_ICON_SET.'buy_bank.gif', $action, $hidden);
//
//		$lang = $module->loadLangGWF();
//		
//		$tVars = array(
//			'lang' => $lang,
//			'user' => $user,
//			'order_c' => $order,
//			'order' => Module_Payment::displayOrder3S($module2, $order, $gdo, $user, $sitename, $buttons),
//		);
//		return $module->templatePHP('pay.php', $tVars);
	}
}
?>