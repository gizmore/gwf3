<?php
require_once 'Backpack.php';
final class Item_Skateboard extends Item_Backpack
{
	public function getItemDescription() { 'A cool skateboard. It reduces your goto and explore times.'; }
	public function getItemPrice() { return 225.00; }
	public function getItemLevel() { return 4; }
	public function getItemDropChance() { return 30.0; }
	
// 	public function getMountWeight() { return 0; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 0; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.95; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => 1.80,
		);
	}
}
?>