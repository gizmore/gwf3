<?php
final class Seattle_Ares extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_AresMan'); }
	public function getFoundPercentage() { return 60.0; }

// 	public function getFoundText(SR_Player $player) { return "You found the local Ares weapon store. The Ares company seems to have a store everywhere."; }
// 	public function getEnterText(SR_Player $player) { return "You enter the Ares weapon store. You see some weapons in a rack behind the counter. The salesman greets you as you walk in."; }
// 	public function getHelpText(SR_Player $player) { return 'Use #view, #buy and #sell here. Use #talk to talk to the salesman.'; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Knife', 100.0, 250),
			array('Stiletto', 100.0, 200),
			array('SamuraiSword', 100.0, 1250),
			array('Flashbang', 100.0, 950),
			array('AresLightFire', 100.0, 1000),
			array('AresPredator', 100.0, 1250),
			array('AresViper', 100.0, 1500),
			array('Fichetti', 100.0, 1250),
			array('RugerWarhawk', 100.0, 1650),
			array('LeatherVest', 100.0, 250),
			array('ChainVest', 100.0, 1500),
			array('KevlarVest', 100.0, 14000),
			array('FirstAid', 100.0, 450),
			array('Ammo_Arrow', 100.0, 9.95),
			array('Ammo_4mm', 100.0, 29.95),
			array('Ammo_5mm', 100.0, 29.95),
			array('Ammo_7mm', 100.0, 39.95),
			array('Ammo_9mm', 100.0, 49.95),
			array('Ammo_11mm', 100.0, 59.95),
			array('Ammo_Shotgun', 100.0, 69.95),
		);
	}
	
}
?>