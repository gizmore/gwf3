<?php
final class Chicago_Cardealer extends SR_Store
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFoundPercentage() { return 55.0; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Aygo1000', 100.0, 7000),
			array('Famstar2400', 100.0, 13000),
			array('XDStar2500', 100.0, 29000),
			array('Kingstar2600', 100.0, 39000),
			array('Razor1911', 100.0, 86000),
			array('Crucifer235', 100.0, 9500),
		);
	}
}
?>
