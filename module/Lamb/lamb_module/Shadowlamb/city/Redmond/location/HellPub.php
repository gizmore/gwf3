<?php
final class Redmond_HellPub extends SR_Location
{
	public function getFoundPercentage() { return 50.00; }
	public function getFoundText() { return sprintf('You find a pub with a lot of motorbikes in front of it. The sign reads "Hell`s Pub".'); }
	public function getEnterText(SR_Player $player) { return 'You enter the Hell`s Pub. A few bikers are playing pool, a few others drink some beer.'; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "You can use {$c}ttb(arkeeper), {$c}ttp(ool_player) and {$c}ttd(rinking_guest) here."; }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Redmond_Hellkeeper', 'ttp'=>'Redmond_Hellplayer', 'ttd'=>'Redmond_Helldrinker'); }
}
?>