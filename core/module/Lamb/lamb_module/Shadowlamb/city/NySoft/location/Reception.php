<?php
final class NySoft_Reception extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Secretary'); }
	public function getFoundText(SR_Player $player) { return 'You found the NySoft reception. Was not well hidden!'; }
	public function getEnterText(SR_Player $player) { return 'You walk to the reception and spot a beatiful secretary.'; }
}
?>