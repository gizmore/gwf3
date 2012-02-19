<?php
final class Item_XDStar2500 extends SR_Mount
{
	public function getItemDescription() { return 'An old and used minivan from the Famstar family produced by Unico, but it\'s in good shape. It has 2450ccm and 100kg storage with a maxspeed of 155km/h.'; }
	public function getItemPrice() { return 2900.00; }
	
	public function getMountWeight() { return 100000; }
	public function getMountPassengers() { return 6; }
	public function getMountLockLevel() { return 6; }
	public function getMountTime($eta) { return $eta * 0.69; }
}
?>
