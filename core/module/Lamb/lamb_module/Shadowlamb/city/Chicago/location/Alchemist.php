<?php
final class Chicago_Alchemist extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Alchemist_NPC'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('EmptyBottle', 100.0, 9.95),
			array('WaterBottle', 100.0, 99.95),
			array('NinjaPotion', 100.0, 500),
			array('StrengthElixir', 100.0, 600),
			array('QuicknessPotion', 100.0, 400),
			array('AimWater', 100.0, 650),
			array('Stimpatch', 100.0, 1200),
			array('Ether', 100.0, 2500),
			array('Mandrake', 100.0, 3000),
		);
	}
}
?>
