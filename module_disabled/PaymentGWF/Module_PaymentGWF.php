<?php
require_once 'module/Payment/GWF_PaymentModule.php';

/**
 * Pay with GWF credits.
 * @author gizmore
 */
final class Module_PaymentGWF extends GWF_PaymentModule
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return GWF_SITENAME; }
	public function getSiteNameToken() { return 'gwf'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentGWF&me=Pay';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		return Module_Payment::tinyform('Pay GWF', 'img/'.GWF_ICON_SET.'buy_gwf.gif', $action, $hidden);
	}
	
	public function canAfford($user, $price)
	{
		if ($user === false) {
			return false;
		}
		
		if ($user->isAdmin()) {
			return true;
		}
		
		return $user->getMoney() >= $price;
	}
	
	/**
	 * Returns error message or false.
	 * @param GWF_Order $order
	 * @param GWF_User $user
	 * @return string | false
	 */
	public function canAffordB(GWF_Order $order, $user)
	{
		if ($user === false) {
			return false;
		}
		
		if ($user->isAdmin()) {
			return false;
		}

		$money = $user->getMoney();
		$price = $order->getOrderPriceTotal();
		$left = $money - $price;
		if ($left >= 0) {
			return false;
		}
		
		$lang = $this->loadLangGWF();
		return GWF_HTML::error('Buy with GWF', $lang->lang('err_funds', array(Module_Payment::displayPrice($money), Module_Payment::displayPrice($price), Module_Payment::displayPrice(-$left))));
	}
	
	###############################
	### Load GWF Language stuff ###
	###############################
	public function loadLangGWF()
	{
		static $load = true;
		if ($load === true)
		{
			$load = new GWF_LangTrans($this->getDir().'/lang/pay_gwf');
		}
		return $load;
	} 
}

?>
