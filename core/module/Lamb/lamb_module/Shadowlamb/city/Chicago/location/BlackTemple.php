<?php
final class Chicago_BlackTemple extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_BlackTempleShamane'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return 'You think you located the local temple. You think you may #enter.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Temple. You see a shamane in a black robe approaching.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}learn or {$c}courses here to see the skill(s) to learn. You can also {$c}talk to the shamane. Also a shop is available here. User #view, #buy, #sell, as usual."; }

	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('AlchemicPotion_of_fireball:6', 100.0, 19999.0),
		);
	}

	public function getFields(SR_Player $player)
	{
		$p = $player->getTemp(Seattle_Shamane::TEMP_PISSED, 0) * 250;
		return array(
//G			array('berzerk', 3500+$p),
//G			array('blow', 2500+$p),
//W			array('bunny', 2500+$p),
//W			array('calm', 2500+$p),
//G			array('chameleon', 3500+$p),
			array('fireball', 4500+$p),
			array('firebolt', 2500+$p),
			array('firewall', 8500+$p),
			array('flu', 2000+$p),
//G			array('freeze', 4500+$p),
//G			array('goliath', 3500+$p),
//G			array('hawkeye', 3500+$p),
//W			array('heal', 4500+$p),
// 			array('magicarp', 19500+$p),
			array('poison_dart', 4000+$p),
//W			array('rabbit', 5000+$p),
// 			array('teleport', 5000+$p),
// 			array('teleportii', 15000+$p),
// 			array('teleportiii', 500000+$p),
// 			array('teleportiv', 5000000+$p),
//G			array('tornado', 17000+$p),
// 			array('turtle', 6500+$p),
// 			array('vulcano', 25000+$p),
// 			array('whirlwind', 9500+$p),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		$b = chr(2);
		parent::onEnter($player);
		$p = $player->getParty();
		$p->notice("The shamane says: \"Hi, do you want to {$b}{$c}learn{$b} the arcane powers of {$b}magic{$b}?\"");
	}
}
?>