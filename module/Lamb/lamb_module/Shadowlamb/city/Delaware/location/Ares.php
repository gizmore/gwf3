<?php
final class Delaware_Ares extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_AresMan'); }
	public function getFoundPercentage() { return 60.0; }
	public function getFoundText(SR_Player $player) { return "You found the local Ares weapon store. The Ares company seems to have a store everywhere."; }
	public function getEnterText(SR_Player $player) { return "You enter the Ares weapon store. You see some weapons in a rack behind the counter. The salesman greets you as you walk in."; }
	public function getHelpText(SR_Player $player) { return 'Use #view, #buy and #sell here. Use #talk to talk to the salesman.'; }

	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Knife'),
			array('Stiletto'),
			array('SamuraiSword'),
			array('Flashbang'),
			array('AresLightFire'),
			array('AresPredator'),
			array('AresViper'),
			array('Fichetti'),
			array('RugerWarhawk'),
			array('LeatherVest'),
			array('ChainVest'),
			array('KevlarVest'),
			array('FirstAid'),
			array('Ammo_5mm'),
			array('Ammo_7mm'),
			array('Ammo_9mm'),
			array('Ammo_11mm'),
			array('Ammo_Shotgun'),
			array('Ammo_Arrow'),
		);
	}
	
}
?>