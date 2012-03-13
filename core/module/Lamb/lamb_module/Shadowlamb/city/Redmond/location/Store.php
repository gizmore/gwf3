<?php
final class Redmond_Store extends SR_Store
{
// 	public function getFoundText(SR_Player $player) { return 'You find a small Store. There are no employees as all transactions are done by slot machines.'; }
	public function getFoundPercentage() { return 70.00; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Redmond Store. No people or employees are around.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}view, {$c}buy and {$c}sell here."; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Pringles', 100.0, 2.50),
			array('FirstAid', 100.0, 250),
			array('Cap', 100.0, 49.95),
			array('Clothes', 100.0, 89.95),
			array('Sneakers', 100.0, 29.95),
			array('Sandals', 100.0, 9.95),
			array('Trousers', 100.0, 69.95),
			array('Shorts', 100.0, 49.95),
			array('Backpack', 100.0, 69.95),
			array('Bike', 100.0, 499.95),
			array('Scanner_v1', 100.0, 229.95),
		);
	}
}
?>