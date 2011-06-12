<?php
require_once 'module/Payment/GWF_PaymentModule.php';

final class Module_PaymentBank extends GWF_PaymentModule
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getPrice() { return 19.95; }
	
	public function onInstall($dropTable)
	{
		return parent::onInstall($dropTable).
		$this->installVars(array(
			'bank_bic' => array('', 'text', '0', '11'),
			'bank_iban' => array('', 'text', '0', '34'),
			'bank_name1' => array('', 'text', '0', '128'),
			'bank_name2' => array('', 'text', '0', '128'),
		));
	}
	
	public function cfgBIC() { return $this->getModuleVar('bank_bic'); }
	public function cfgIBAN() { return $this->getModuleVar('bank_iban'); }
	public function cfgFirstName() { return $this->getModuleVar('bank_name1'); }
	public function cfgLastName() { return $this->getModuleVar('bank_name2'); }
		
	#########################
	### GWF_PaymentModule ###
	#########################
	public function getSiteName() { return 'Bank Transfer'; }
	public function getSiteNameToken() { return 'bank'; }
	public function getSupportedCurrencies() { return array('EUR', 'USD'); }
	public function displayPaysiteButton(GWF_Module $module, GWF_Order $order, GWF_Orderable $gdo, GWF_User $user)
	{
		$action = GWF_WEB_ROOT.'index.php?mo=PaymentBank&me=Pay';
		$hidden = GWF_Form::hidden('gwf_token', $order->getOrderToken());
		return Module_Payment::tinyform('Bank Transaction', 'img/buy_bank.gif', $action, $hidden);
	}
	
	###############################
	### Load GWF Language stuff ###
	###############################
	public function loadLangGWF()
	{
		static $load = true;
		if ($load === true)
		{
			$load = new GWF_LangTrans($this->getDir().'/lang/pay_bank');
		}
		return $load;
	}
}
?>
