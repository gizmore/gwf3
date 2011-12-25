<?php
final class Delaware_Store extends SR_Store
{
	public function getFoundText(SR_Player $player) { return 'You find a small Store. There are no employees as all transactions are done by slot machines.'; }
	public function getFoundPercentage() { return 70.00; }
	public function getEnterText(SR_Player $player) { return 'You enter the Store. No people or employees are around.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}view, {$c}buy and {$c}sell here."; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('LeatherVest', 100.0, 300),
			array('FirstAid', 100.0, 700),
			array('Boots', 100.0, 400),
			array('Trousers', 100.0, 100),
			array('Knife', 100.0, 200),
			array('Backpack', 100.0, 500),
			array('RacingBike', 100.0, 1000),
			array('Scanner_v3', 100.0, 2000),
			array('Credstick', 100.0, 129.95),
			array('Holostick', 100.0, 995.95),
		);
	}
}
?>