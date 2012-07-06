<?php
require_once 'Moped.php';
class Item_DavyHasselhoff extends Item_Moped
{
	public function getItemDescription() { return 'This motorbike is a David Hasselhoff themed Harley Davidson from the two-twenties.'; }
	public function getItemPrice() { return 4500; }
	
// 	public function getMountWeight() { return 6000; }
	public function getMountPassengers() { return 2; }
// 	public function getMountLockLevel() { return 2; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.92; }

	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'lock' => 2,
			'tuneup' => '7.30',
			'transport' => '6.00',
		);
	}
}
?>
