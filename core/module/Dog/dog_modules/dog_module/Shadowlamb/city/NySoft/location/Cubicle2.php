<?php
final class NySoft_Cubicle2 extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Christian'); }
	public function getFoundText(SR_Player $player) { return 'You found some more cubicles. "YAWN", you think to yourself.'; }
	public function getEnterText(SR_Player $player) { return 'You look around a few cubicles and see some people scratching their head.'; }
	public function getFoundPercentage() { return 100; }
}
?>