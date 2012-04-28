<?php
final class TrollHQ_Exit extends SR_Exit
{
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the troll headquarter.'; }
	public function getExitLocation() { return 'Delaware_TrollHQ'; }
}
?>