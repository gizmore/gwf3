<?php
final class Renraku_Lobby extends SR_Location
{
	public function getFoundPercentage() { return 100; }
	public function getFoundText(SR_Player $player) { return 'You found a beautiful lobby, with a lot of glass.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the lobby, in the middle is a nice sculpture of ice or milky glass. Nobody is around.'; }
}
?>