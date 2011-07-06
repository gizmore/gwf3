<?php
require_once 'Backpack.php';
class Item_Bike extends Item_Backpack
{
	public function getItemDescription() { return 'A cheap but solid bicycle.'; }
	public function getItemPrice() { return 695.00; }
	
	public function getMountWeight() { return 2500; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 0; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.80; }
}
?>
