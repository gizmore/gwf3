<?php
final class PaymentFree_Pay extends GWF_Method
{
//	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($order = GWF_Order::getByToken(Common::getPost('gwf_token')))) {
			return $module->error('err_order');
		}
		
		if (!$order->isCreated()) {
			return $module->error('err_order');
		}
		
		if ($order->getOrderPriceTotal() > 0) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('pay_x')) {
			return $this->onPay($module, $order);
		}
		
		return $this->templatePay($module, $order);
	}
	
	private function onPay(Module_PaymentFree $module, GWF_Order $order)
	{
		$form = $this->tinyCaptchaForm($module, $order);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templatePay($module, $order);
		}
		
		$module2 = $order->getOrderModule();
		$module2->onInclude();
		$module2->onLoadLanguage();
		
		return Module_Payment::onExecuteOrderS($module2, $order);
	}
	
	public function validate_gwf_token($m, $arg) { return false; }
	
	private function templatePay(Module_PaymentFree $module, GWF_Order $order)
	{
		$module2 = $order->getOrderModule();
		$module2->onLoadLanguage();
		$gdo = $order->getOrderData();
		$user = $order->getUser();
		$sitename = $module->getSiteName();
		
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentFree&me=Pay';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		
		$form = $this->tinyCaptchaForm($module, $order);
		$buttons = $form->templateY('Free', $action);
		
//		$buttons = Module_Payment::tinyform('Free', 'img/'.GWF_ICON_SET.'buy_free.gif', $action, $hidden);

//		$lang = $module->loadLangGWF();
		
		
//		if (false !== ($error = $module->canAffordB($order, $user))) {
//			return $error;
//		}
//		
		$tVars = array(
//			'lang' => $lang,
			'user' => $user,
			'order' => Module_Payment::displayOrder3S($module2, $order, $gdo, $user, $sitename, $buttons),
		);
		return $module->templatePHP('pay.php', $tVars);
	}
	
	private function tinyCaptchaForm(Module_PaymentFree $module, GWF_Order $order)
	{
		$data = array(
			'captcha' => array(GWF_Form::CAPTCHA),
			'gwf_token' => array(GWF_Form::HIDDEN, $order->getOrderToken()),
			'pay' => array(GWF_Form::SUBMIT_IMG, 'free_pay'),
		);
		return new GWF_Form($this, $data);
	}
}
?>