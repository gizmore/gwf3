<?php
final class Redmond_Ares extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('tt1' => 'Redmond_AresDwarf_I', 'tt2' => 'Redmond_AresDwarf_II'); }
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Clothes'),
			array('LeatherVest'),
			array('ChainVest'),
			array('Knife'),
			array('Stiletto'),
			array('ShortSword'),
			array('AresLightFire'),
			array('AresPredator'),
			array('Ammo_5mm'),
			array('Ammo_7mm'),
			array('Ammo_9mm'),
			array('Ammo_11mm', 100.0, 200),
			array('Flashbang'),
			array('SmallFirstAid'),
			array('FirstAid'),
			array('SportBow'),
			array('Ammo_Arrow'),
		);
	}
	public function getFoundPercentage() { return 60.00; }
	public function getFoundText(SR_Player $player) { return sprintf('You found the local Ares weapon store. You won`t get heavy or illegal stuff here.'); }
	public function getHelpText(SR_Player $player) { return "You can use #tt1, #tt2, #view, #buy and #sell here."; }
	public function getEnterText(SR_Player $player) { return "You enter the Ares weapon store. Two dwarfs are behind the counter. One of the Ares sale officers greets you."; }
} 
?>