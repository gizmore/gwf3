<?php
final class Redmond_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_Hotelier'); }
	public function getFoundText() { return 'You find a small Hotel. Looks a bit cheap but should suite your needs.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Redmond Hotel... somehow you feel home here.'; }
	public function getFoundPercentage() { return 100.00; }
}
?>