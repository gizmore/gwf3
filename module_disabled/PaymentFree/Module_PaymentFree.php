<?php
require_once 'module/Payment/GWF_PaymentModule.php';

final class Module_PaymentFree extends GWF_PaymentModule
{
	
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return 'Free'; }
	public function getSiteNameToken() { return 'free'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentFree&me=Pay';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		return Module_Payment::tinyform('Free', 'img/'.GWF_ICON_SET.'buy_free.png', $action, $hidden);
	}
	
	public function canAfford($user, $price)
	{
		return $price == 0;
	}
	
	
}
?>