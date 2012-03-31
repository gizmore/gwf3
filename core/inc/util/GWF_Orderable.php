<?php
/**
 * Interface to make ordering of GDO rows possible.
 * @author gizmore
 * @version 3.00
 */
interface GWF_Orderable
{
	#################
	### GWF_Order ###
	#################
	public function canOrder(GWF_User $user); # return true;
	public function canRefund(GWF_User $user); # return true;
	public function canPayWithGWF(GWF_User $user); # return true;
	public function canAutomizeExec(GWF_User $user); # return true;
	public function needsShipping(GWF_User $user); # return false;

	public function getOrderWidth(); # return 0.0; (cm)
	public function getOrderHeight(); # return 0.0; (cm)
	public function getOrderDepth(); # return 0.0; (cm)
	public function getOrderWeight(); # return 0.0; (kg)

	public function getOrderModuleName();
	public function getOrderPrice(GWF_User $user); # return 9.95;
	public function getOrderItemName(GWF_Module $module, $lang_iso);
	public function getOrderDescr(GWF_Module $module, $lang_iso); # return "DESCR"
	public function getOrderStock(GWF_User $user); # return 1;
	public function getOrderCancelURL(GWF_User $user);
	public function getOrderSuccessURL(GWF_User $user);

	public function displayOrder(GWF_Module $module); # return 'html';
	public function executeOrder(GWF_Module $module, GWF_User $user); # return false;
}
