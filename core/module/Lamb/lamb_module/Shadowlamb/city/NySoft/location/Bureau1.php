<?php
final class NySoft_Bureau1 extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Stolemeyer'); }
	public function getFoundText(SR_Player $player) { return 'You found a bureau, "R. Stolemeyer" is the sign it reads in expensive looking wood.'; }
	public function getEnterText(SR_Player $player) { return 'You enter a large and mahagoni style bureau. A fat human sits behind his desk.'; }
	public function getFoundPercentage() { return 100; }
}
?>