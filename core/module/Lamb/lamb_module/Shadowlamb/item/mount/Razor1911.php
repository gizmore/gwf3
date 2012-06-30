<?php
final class Item_Razor1911 extends SR_Mount
{
	public function getItemDescription() { return 'A sports car produced by Porsche. It has 1.911 litres of cylinder capacity and is a tribute to the legendary Razor1911 hacking group.'; }
	public function getItemPrice() { return 11911; }
	
// 	public function getMountWeight() { return 12000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 8; }
// 	public function getMountTime($eta) { return $eta * 0.45; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => '11.00',
			'transport' => '12.00',
		);
	}
}
?>
