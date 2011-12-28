<?php
final class Chicago_Archery extends SR_School
{
	public function getCommands(SR_Player $player) { return array('learn', 'courses', 'view', 'buy'); }
	public function getFoundPercentage() { return 10.00; }
	public function getFoundText(SR_Player $player) { return "You find a small archery."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Archer'); }
	public function getEnterText(SR_Player $player) { return "You enter the archery. You see some elves practicing their bow skills. An elve in a dark costume approaches."; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('SportBow', 100.0, 179.95),
			array('ElvenBow', 100.0, 1399.95),
			array('DarkBow', 100.0, 2599.95),
			array('ReignBow', 100.0, 7999.95),

			array('Ammo_Arrow', 100.0, 150, 30),
			array('Ammo_Arrow', 100.0, 250, 75),
			
			array('Rune_of_bows:0.1', 100.0, 1000),
			array('Rune_of_attack:0.1', 100.0, 1900),
			
			array('Horse', 100.0, 17000),
		);
	}
	public function getFields(SR_Player $player)
	{
		return array(
			array('bows', 600), 
		);
	}
}
?>