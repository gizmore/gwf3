<?php
final class Delaware_Alchemist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Alchemist'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return 'In a small sidestreet you found an alchemic store: "Simons\'s Alchemy".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the store. A gnome greets you: "Welcome, brew one, i am Simon."'; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('EmptyBottle'),
			array('WaterBottle'),
			array('NinjaPotion'),
			array('StrengthElixir'),
			array('QuicknessPotion'),
			array('AimWater'),
			array('Stimpatch', 100.0, 1000),
			array('ScrollOfWisdom', 100.0, 200),
			array('Ether', 100.0, 2000),
		);
	}
}
?>