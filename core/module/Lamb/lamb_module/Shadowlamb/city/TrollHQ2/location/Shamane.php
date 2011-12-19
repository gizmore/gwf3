<?php
final class TrollHQ2_Shamane extends SR_Location
{
	public function getAreaSize() { return 26; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'TrollHQ2_TrollShamane'); }
	public function getFoundPercentage() { return 50.00; }
}
?>
