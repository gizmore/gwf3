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
			array('Ammo_5mm'),
			array('Ammo_7mm'),
			array('Ammo_9mm'),
			array('Ammo_11mm'),
			array('Ammo_Arrow'),
			array('Ammo_Shotgun'),
			array('Stimpatch', 100.0, 750),
			array('FirstAid', 100.0, 500),
			array('AresViper', 100.0, 1250),
			array('Fichetti', 100.0, 1450),
			array('RugerWarhawk', 100.0, 1650),
			array('KevlarVest', 90.0, 55000),
			array('KevlarHelmet', 90.0, 35000),
			array('KevlarLegs', 90.0, 25000),
			array('KevlarShield', 90.0, 35000),
			array('LightBodyArmor', 10.0, 75000),
			array('CombatHelmet', 10.0, 25000),
		);
	}
	
}
?>