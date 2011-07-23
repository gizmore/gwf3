<?php
require_once 'RacingBike.php';
final class Item_Moped extends Item_RacingBike
{
	public function getItemDescription() { return 'An old 125ccm moped.'; }
	public function getItemPrice() { return 1500; }
	
	public function getMountWeight() { return 4000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 1; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.88; }
}
?>
