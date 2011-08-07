<?php
final class Redmond_Alchemist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_Alchemist_NPC'); }
	public function getFoundPercentage() { return 80.00; }
	public function getFoundText(SR_Player $player) { return 'In a sidestreet you found an interesting store: "Carstens Alchemic Utils".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the alchemistic store. A tall elve greets you as you walk towards the counter.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "In stores you can use {$c}view, {$c}buy and {$c}sell. Use {$c}talk to talk to the elve."; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('EmptyBottle', 100.0, 19.95),
			array('NinjaPotion', 100.0, 250),
			array('StrengthPotion', 100.0, 150),
			array('QuicknessPotion', 100.0, 200),
			array('AimWater', 100.0, 300),
			array('Stimpatch', 100.0, 1300),
			array('ScrollOfWisdom', 100.0, 800),
		);
	}
}
?>