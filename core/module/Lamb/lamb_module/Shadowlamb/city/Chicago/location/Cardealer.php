<?php
final class Chicago_Cardealer extends SR_Store
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFoundPercentage() { return 55.0; }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Aygo1000', 100.0, 5000),
			array('Famstar2400', 100.0, 9000),
			array('XDStar2500', 100.0, 19000),
			array('Kingstar2600', 100.0, 27000),
			array('Razor1911', 100.0, 84000),
			array('Crucifer235', 100.0, 6500),
		);
	}
}
?>