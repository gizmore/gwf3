<?php
require_once 'Bike.php';
class Item_RacingBike extends Item_Bike
{
	public function getItemDescription() { return 'A cheap but solid bicycle.'; }
	public function getItemPrice() { return 1295.00; }
	
// 	public function getMountWeight() { return 1500; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 1; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.85; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => '2.50',
			'transport' => '1.50',
		);
	}
}
?>
