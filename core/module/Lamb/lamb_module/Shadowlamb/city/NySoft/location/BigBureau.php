<?php
final class NySoft_BigBureau extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'NySoft_Andrew'); }
	public function getFoundText(SR_Player $player) { return 'You found a big bureau, "A. Northwood" is the sign it reads in expensive looking wood.'; }
	public function getEnterText(SR_Player $player) { return 'You enter a large and mahagoni style bureau. A smart looking elve sits behind a brown desk.'; }
}
?>