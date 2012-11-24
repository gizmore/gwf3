<?php
final class Delaware_Temple extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Shamane'); }
	public function getFoundPercentage() { return 50.00; }
	
	public function getFoundText(SR_Player $player) { return 'You see a big gray building that looks like a temple. Probably the magic school.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Temple. You see a grayhat shamane in a robe approaching.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}learn or {$c}courses here to see the skill(s) to learn. You can also {$c}talk to the shamane."; }
	
	public function getFields(SR_Player $player)
	{
		$p = $player->getTemp(Seattle_Shamane::TEMP_PISSED, 0) * 250;
		return array(
			array('magic', 1500+$p),
			array('casting', 2500+$p),
			array('orcas', 4000+$p),
			array('berzerk', 4500+$p),
			array('freeze', 2500+$p),
			array('calm', 2000+$p),
			array('heal', 3500+$p),
			array('flu', 1000+$p),
			array('poison_dart', 3000+$p),
			array('firebolt', 2500+$p),
			array('fireball', 5000+$p),
			array('blow', 2500+$p),
		);
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$this->partyMessage($player, 'welcome');
// 		$p->notice("The shamane says: \"Hi, do you want to {$b}{$c}learn{$b} the arcane powers of {$b}magic{$b}?\"");
	}
}
?>
