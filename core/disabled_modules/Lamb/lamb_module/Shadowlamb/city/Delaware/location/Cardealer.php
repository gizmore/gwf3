<?php
final class Delaware_Cardealer extends SR_Store
{
	public function getFoundPercentage() { return 35.0; }

// 	public function getFoundText(SR_Player $player) { return 'You found a cardealer. Quite nice cars here, and they probably are expensive.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the parking range and take a look at the cars.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Famstar2400', 100.0, 12500),
			array('Razor1911', 100.0, 86000),
			array('Crucifer235', 100.0, 9500),
		);
	}
}
?>
