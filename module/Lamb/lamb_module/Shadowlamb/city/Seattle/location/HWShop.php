<?php
final class Seattle_HWShop extends SR_School
{
	public function getFoundPercentage() { return 35.00; }
	public function getFoundText(SR_Player $player) { return "You find a small store selling cyberdecks. It has opened."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_HWGuy'); }
	public function getEnterText(SR_Player $player) { return "You enter the hardware store. You see a darkelve sitting behind the counter."; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
	public function getFields(SR_Player $player)
	{
		return array(
			array('computers', 3500),
			array('electronics', 3500),
		);
	}
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('AM500'),
			array('AT1024'),
			array('DG442'),
		);
	}
}
?>