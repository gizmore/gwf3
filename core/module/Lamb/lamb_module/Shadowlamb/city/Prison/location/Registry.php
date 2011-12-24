<?php
final class Prison_Registry extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk'=>'Prison_Secretary'); }
	public function getEnterText(SR_Player $player) { return 'You walk to the registry. A secretary sits behind a desk.'; }
	public function getHelpText(SR_Player $player) { return 'Use #talk to talk to the secretary.'; }
}
?>