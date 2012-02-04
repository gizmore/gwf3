<?php
require_once 'SR_SearchRoom.php';
abstract class SR_Cell extends SR_SearchRoom
{
	public function getFoundPercentage() { return 80; }
	public function getFoundText(SR_Player $player) { return sprintf('You found %s.', get_class($this)); }
	public function getEnterText(SR_Player $player) { return sprintf('You enter %s.', get_class($this)); }
	
	public function onEnter(SR_Player $player)
	{
		$player->msg('1118');
// 		$player->message(sprintf('You find no way to enter %s.', get_class($this)));
		return false;
	}
}
?>