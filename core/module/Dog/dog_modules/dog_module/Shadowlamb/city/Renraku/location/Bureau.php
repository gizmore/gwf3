<?php
final class Renraku_Bureau extends SR_Location
{
	public function getFoundPercentage() { return 50; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'Renraku_OfficeWorker'); }
	
// 	public function getFoundText(SR_Player $player) { return 'You find a room that with actually someone working in it.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter a bureau. A worker is sitting behind his desk.'; }
// 	public function getHelpText(SR_Player $player) { return 'Use #talk to talk to the office worker.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
