<?php
final class Chicago_Shrine extends SR_School
{
	public function getFoundPercentage() { return 25.00; }
	public function getFoundText(SR_Player $player) { return "You find a hidden temple. It looks like the Chicago Shrine."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_ShrineMonk'); }
	public function getEnterText(SR_Player $player) { return "You enter the shrine. A monk i brown robe approaches."; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
	public function getCommands(SR_Player $player) { return array('view', 'buy', 'sell', 'learn', 'courses'); }
	public function getFields(SR_Player $player)
	{
		return array(
			array('melee', 2500),
			array('ninja', 4500),
			array('sharpshooter', 7500),
		);
	}
	
// 	public function getStoreItems(SR_Player $player)
// 	{
// 		return array(
// 			array('AT1024'),
// 			array('DG442'),
// 			array('GN4884'),
// 			array('NIA62'),
// 		);
// 	}
}
?>