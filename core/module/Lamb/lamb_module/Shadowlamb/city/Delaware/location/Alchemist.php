<?php
final class Delaware_Alchemist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Alchemist_NPC'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return 'In a small sidestreet you found an alchemic store: "Simons\'s Alchemy".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the store. A gnome greets you: "Welcome, brew one, I am Simon."'; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('WaterBottle', 100.0, 79.95),
			array('NinjaPotion', 100.0, 500),
			array('StrengthElixir', 100.0, 600),
			array('QuicknessPotion', 100.0, 400),
			array('AimWater', 100.0, 650),
			array('Stimpatch', 100.0, 1000),
			array('ScrollOfWisdom', 100.0, 200),
			array('Ether', 100.0, 2000),
			array('Mandrake', 100.0, 3000),
		);
	}
}
?>