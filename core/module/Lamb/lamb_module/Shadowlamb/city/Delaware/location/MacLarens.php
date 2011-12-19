<?php
final class Delaware_MacLarens extends SR_Location
{
	public function getFoundPercentage() { return 50.00; }
	public function getFoundText(SR_Player $player) { return "You found a pub, the 'MacLarens'. It looks clean and peaceful."; }
	public function getEnterText(SR_Player $player) { return 'You enter the pub, and see a few people: a Johnson, some guests and the barkeeper.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb, {$c}ttj and {$c}ttg1,{$c}ttg2,{$c}ttg3 here."; }
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Delaware_MCBarkeeper','ttj'=>'Delaware_MCJohnson','ttg1'=>'Delaware_MCGuest1','ttg2'=>'Delaware_MCGuest2','ttg3'=>'Delaware_MCGuest3'); }
	
}
?>