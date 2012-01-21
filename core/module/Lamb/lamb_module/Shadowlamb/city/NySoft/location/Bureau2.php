<?php
final class NySoft_Bureau2 extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Grayfox'); }
	public function getFoundText(SR_Player $player) { return 'You found a bureau, "G. Ray Fox" is the sign it reads in expensive looking wood.'; }
	public function getEnterText(SR_Player $player) { return 'You enter a mahagoni style bureau. A small elve is sitting behind the desk.'; }
	public function getFoundPercentage() { return 100; }
}
?>