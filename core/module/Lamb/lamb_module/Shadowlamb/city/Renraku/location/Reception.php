<?php
final class Renraku_Reception extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Renraku_Secretary'); }
	
// 	public function getEnterText(SR_Player $player) { return 'You enter the reception. A secretary sits behind the desk.'; }
// 	public function getHelpText(SR_Player $player) { return 'Use #talk to talk to the secretary.'; }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>