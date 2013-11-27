<?php
require_once 'Pockets.php';
class Item_Backpack extends Item_Pockets
{
	const BACKPACK_WEIGHT = 2000;
	public function getItemDescription() { 'A backpack allows you to walk a bit faster and carry '.Shadowfunc::displayWeight(self::BACKPACK_WEIGHT); }
	public function getItemPrice() { return 125.00; }
	
// 	public function getMountWeight() { return 0; }
	public function getMountPassengers() { return 1; }
// 	public function getMountLockLevel() { return 0; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.95; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => 1.00 + $this->getPocketsTuneup($player),
			'max_weight' => self::BACKPACK_WEIGHT,
		);
	}
}
?>
