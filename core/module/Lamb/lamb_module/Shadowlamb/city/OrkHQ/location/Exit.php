<?php
final class OrkHQ_Exit extends SR_Exit
{
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Ork Headquarters.'; }
	public function getExitLocation() { return 'Redmond_OrkHQ'; }
}
?>