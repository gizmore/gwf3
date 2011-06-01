<?php
final class Item_Moped extends SR_Mount
{
	public function getItemDescription() { return 'An old 125ccm moped.'; }
	public function getItemPrice() { return 4500; }
	
	public function getMountWeight() { return 4000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 1; }
	public function getMountTime($eta) { return $eta * 0.7; }
}
?>
