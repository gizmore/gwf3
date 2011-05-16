<?php
final class Redmond_Store extends SR_Store
{
	public function getFoundText() { return 'You find a small Store. There are no employees as all transactions are done by slot machines.'; }
	public function getFoundPercentage() { return 70.00; }
	public function getEnterText(SR_Player $player) { return 'You enter the Redmond Store. No people or employees are around.'; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "You can use {$c}view, {$c}buy and {$c}sell here."; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Pringles', 100.0, 2.50),
			array('FirstAid'),
			array('Cap'),
			array('Clothes'),
			array('Sneakers'),
			array('Sandals'),
			array('Trousers'),
			array('Shorts'),
			array('Scanner_v1'),
		);
	}
}
?>