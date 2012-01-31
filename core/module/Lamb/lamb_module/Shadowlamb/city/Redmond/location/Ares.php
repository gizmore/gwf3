<?php
final class Redmond_Ares extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('tt1' => 'Redmond_AresDwarf_I', 'tt2' => 'Redmond_AresDwarf_II'); }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Clothes', 100.0, 100),
			array('LeatherVest', 100.0, 200),
			array('ChainVest', 100.0, 750),
			array('Knife', 100.0, 200),
			array('Stiletto', 100.0, 149.95),
			array('ShortSword', 100.0, 550),
			array('AresLightFire', 100.0, 750),
			array('AresPredator', 100.0, 950),
			array('Flashbang', 100.0, 600),
			array('SmallFirstAid', 100.0, 300),
			array('FirstAid', 100.0, 500),
			array('SportBow', 100.0, 250),
			array('Ammo_Arrow', 100.0, 9.95),
			array('Ammo_4mm', 100.0, 29.95),
			array('Ammo_5mm', 100.0, 29.95),
			array('Ammo_7mm', 100.0, 39.95),
			array('Ammo_9mm', 100.0, 49.95),
			array('Ammo_11mm', 100.0, 59.95),
			array('Ammo_Shotgun', 100.0, 69.95),
			);
	}
	public function getFoundPercentage() { return 60.00; }
	public function getFoundText(SR_Player $player) { return sprintf('You found the local Ares weapon store. You won`t get heavy or illegal stuff here.'); }
	public function getHelpText(SR_Player $player) { return "You can use #tt1, #tt2, #view, #buy and #sell here."; }
	public function getEnterText(SR_Player $player) { return "You enter the Ares weapon store. Two dwarfs are behind the counter. One of the Ares sale officers greets you."; }
} 
?>