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
			array('LeatherVest'),
			array('FirstAid'),
			array('Boots'),
			array('Trousers'),
			array('Knife'),
			array('Backpack'),
			array('RacingBike'),
			array('Scanner_v2'),
		);
	}
}
?>