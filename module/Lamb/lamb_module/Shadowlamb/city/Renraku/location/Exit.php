<?php
final class Renraku_Exit extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return 'The exit of the Renraku Tower. Better be sneaky!'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Renraku building.'; }
	public function getHelpText(SR_Player $player) { return 'You can return to this location to #leave the building.'; }
	public function getCommands(SR_Player $player) { return array('leave'); }
	public function on_leave(SR_Player $player, array $args)
	{
		$this->teleport($player, 'Seattle_Renraku');
	}
}
?>