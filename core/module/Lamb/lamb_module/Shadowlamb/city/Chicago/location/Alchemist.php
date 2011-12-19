<?php
final class Chicago_Alchemist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Alchemist_NPC'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return 'In a small sidestreet you found an alchemic store: "Newton\'s Alchemic Utilities".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the store. A gnome greets you: "Oh hello, come in ... how can i help?!"'; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('EmptyBottle', 100.0, 25.49),
			array('WaterBottle', 100.0, 35.49),
			array('NinjaPotion', 100.0, 500),
			array('StrengthElixir', 100.0, 600),
			array('QuicknessPotion', 100.0, 400),
			array('AimWater', 100.0, 650),
			array('Stimpatch', 100.0, 1200),
			array('Ether', 100.0, 2500),
		);
	}
}
?>