<?php
final class Seattle_Archery extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Archer'); }
	public function getFoundPercentage() { return 50.00; }

// 	public function getFoundText(SR_Player $player) { return "You find a big place with a sign: \"Seattle Archery\". It looks a bit like a golf club."; }
// 	public function getEnterText(SR_Player $player) { return "You enter the archery. You see some elves and humans practicing their bow skills. A woodelve in a green costume approaches."; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('SportBow', 100.0, 179.95),
			array('ElvenBow', 100.0, 1399.95),
//			array('DarkBow'),
			array('Ammo_Arrow', 100.0, 150, 30),
			array('Ammo_Arrow', 100.0, 250, 75),
			
// 			array('Rune_of_bows:0.1', 100.0, 800),
// 			array('Rune_of_attack:0.1', 100.0, 1500),
			
			array('Horse', 100.0, 14000),
		);
	}
	public function getFields(SR_Player $player)
	{
		return array(
			array('bows', 500), 
		);
	}
}
?>
