<?php
final class Delaware_Cardealer extends SR_Store
{
	public function getFoundPercentage() { return 35.0; }
	public function getFoundText(SR_Player $player) { return 'You found a cardealer. Quite nice cars here, and they probably are expensive.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the parking range and take a look at the cars.'; }
//	public function getHelpText(SR_Player $player) { return 'You can use #ttg to talk to the gnome here.'; }
//	public function getNPCS(SR_Player $player) { return array('ttg'=>'Delaware_LibGnome'); }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Famstar2400', 100.0, 9000),
			array('Razor1911', 100.0, 79000),
			array('Crucifer235', 4500),
		);
	}
}
?>