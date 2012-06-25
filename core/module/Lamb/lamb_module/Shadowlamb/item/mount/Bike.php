<?php
require_once 'Backpack.php';
class Item_Bike extends Item_Backpack
{
	public function getItemDescription() { return 'A cheap but solid bicycle.'; }
	public function getItemPrice() { return 195.00; }
	
// 	public function getMountWeight() { return 2500; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 0; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.80; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'transport' => '2.50',
		);
	}
}
?>
