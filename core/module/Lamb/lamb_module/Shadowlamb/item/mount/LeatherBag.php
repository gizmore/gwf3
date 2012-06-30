<?php
require_once 'Pockets.php';
class Item_LeatherBag extends Item_Pockets
{
	const BAG_WEIGHT = 1000;
	public function getItemDescription() { 'A bag allows you to carry '.Shadowfunc::displayWeight(self::BAG_WEIGHT).' more weight.'; }
	public function getItemPrice() { return 65.00; }
	public function getItemLevel() { return 2; }
// 	public function getMountWeight() { return 0; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 0; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.95; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => 0.50,
			'max_weight' => self::BAG_WEIGHT,
		);
	}
}
?>
