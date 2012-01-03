<?php
final class Chicago_Store extends SR_Store
{
	public function getFoundText(SR_Player $player) { return 'You find a small Store. There are no employees as all transactions are done by slot machines.'; }
	public function getFoundPercentage() { return 70.00; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('LeatherVest', 100.0, 300),
			array('FirstAid', 100.0, 700),
			array('Boots', 100.0, 400),
			array('Trousers', 100.0, 100),
			array('LeatherCap', 100.0, 100),
			array('Knife', 100.0, 200),
			array('Scanner_v3', 100.0, 2000),
			array('Scanner_v4', 100.0, 8000),
			array('Credstick', 100.0, 129.95),
			array('Holostick', 100.0, 995.95),
			array('Hourglass', 100.0, 5000000),
		);
	}
	
	public function getEnterText(SR_Player $player)
	{
		if ($player->hasConst('RESCUED_MALOIS'))
		{
			return 'You enter the Store. In front of a slot machine you spot Malois.';
		}
		return 'You enter the Store. No people or employees are around.';
	}
	
	public function getNPCS(SR_Player $player)
	{
		if ($player->hasConst('RESCUED_MALOIS'))
		{
			return array('talk'=>'Chicago_StoreMalois');
		}
		return array();
	}
}
?>