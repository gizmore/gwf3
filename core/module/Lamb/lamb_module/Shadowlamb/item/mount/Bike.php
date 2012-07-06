<?php
require_once 'Backpack.php';
class Item_Bike extends Item_Backpack
{
	public function getItemDescription() { return 'A cheap but solid bicycle.'; }
	public function getItemPrice() { return 195.00; }
	
// 	public function getMountWeight() { return 2500; }
	public function getMountPassengers() { return 1; }
// 	public function getMountLockLevel() { return 0; }
// 	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.80; }
	
	public function getBikeTuneup(SR_Player $player)
	{
		$bo = $player->get('body') * 0.04;
		$st = $player->get('strength') * 0.05;
		return $bo + $st + $qu;
	}
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'tuneup' => '2.00' + $this->getBikeTuneup($player),
			'transport' => '2.50',
		);
	}
}
?>
