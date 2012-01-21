<?php
final class NySoft_Cubicle1 extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Stephen'); }
	public function getFoundText(SR_Player $player) { return 'You found some cubicles. "Boring", you think to yourself.'; }
	public function getEnterText(SR_Player $player) { return 'You look around a few cubicles and see some people typing.'; }
	public function getFoundPercentage() { return 100; }
}
?>