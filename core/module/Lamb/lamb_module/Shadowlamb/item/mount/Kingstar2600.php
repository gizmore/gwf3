<?php
final class Item_Kingstar2600 extends SR_Mount
{
	public function getItemDescription() { return 'An older minivan from the Famstar family produced by Unico. It\'s still in good shape. It has 2450ccm and 120kg storage with a maxspeed of 155km/h.'; }
	public function getItemPrice() { return 3500.00; }
	
// 	public function getMountWeight() { return 120000; }
	public function getMountPassengers() { return 6; }
// 	public function getMountLockLevel() { return 6; }
// 	public function getMountTime($eta) { return $eta * 0.68; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'lock' => 6,
			'tuneup' => '11.00',
			'transport' => '120.00',
		);
	}
}
?>
