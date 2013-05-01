<?php
final class Prison_Bureau extends SR_Location
{
// 	public function getFoundPercentage() { return 100.00; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'Prison_Director'); }
	public function getFoundText(SR_Player $player) { return 'You found the bureau of the prison director.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the bureau. The director sits at his large desk.'; }
	public function getHelpText(SR_Player $player) { return 'Use #talk to talk to the director.'; }
}
?>