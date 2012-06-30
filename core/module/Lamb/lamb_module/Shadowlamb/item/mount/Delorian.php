<?php
final class Item_Delorian extends SR_Mount
{
	public function getItemDescription() { return 'A rebuild of the famous Delorian from Back to the Future. It has only very small power and storage, and is more a funcar.'; }
	public function getItemPrice() { return 2999; }
// 	public function getMountWeight() { return 3000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 2; }
// 	public function getMountTime($eta) { return $eta * 0.60; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => '8.00',
			'transport' => '3.00',
		);
	}
}
?>
