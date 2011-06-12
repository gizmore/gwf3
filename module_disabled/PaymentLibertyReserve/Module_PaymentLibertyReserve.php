<?php
require_once 'module/Payment/GWF_PaymentModule.php';

final class Module_PaymentLibertyReserve extends GWF_PaymentModule
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return 'Liberty Reserve'; }
	public function getSiteNameToken() { return 'lr'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		return 'LR';
	}
		

}

?>
