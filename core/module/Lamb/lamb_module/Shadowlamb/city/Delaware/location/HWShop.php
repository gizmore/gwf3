<?php
final class Delaware_HWShop extends SR_School
{
	public function getFoundPercentage() { return 35.00; }
	public function getFoundText(SR_Player $player) { return "You find the local hacker store. It has opened."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_HWGuy'); }
	public function getEnterText(SR_Player $player) { return "You enter the hardware store. You see a darkelve sitting behind the counter."; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
// 	public function getCommands(SR_Player $player) { return array('view', 'buy', 'learn', 'courses'); }
	public function getFields(SR_Player $player)
	{
		return array(
			array('computers', 2500),
			array('electronics', 2500),
		);
	}
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('AT1024'),
			array('DG442'),
			array('GN4884'),
		);
	}
}
?>