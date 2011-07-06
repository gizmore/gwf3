<?php
require_once 'Pockets.php';
class Item_Backpack extends Item_Pockets
{
	public function getItemDescription() { 'A backpack allows you to walk a bit faster.'; }
	public function getItemPrice() { return 125.00; }
	
	public function getMountWeight() { return 0; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 0; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.95; }
}
?>
