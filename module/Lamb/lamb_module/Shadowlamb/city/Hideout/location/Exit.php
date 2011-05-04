<?php
final class Hideout_Exit extends SR_Tower
{
	public function getEnterText(SR_Player $player) { return 'You enter the punk`s hideout.'; }
	public function getHelpText(SR_Player $player) { return 'You can return to this location to exit the building.'; }
	public function getCommands(SR_Player $player) { return array('leave'); }
	
	public function on_leave(SR_Player $player, array $args)
	{
		$this->teleport($player, 'Redmond_Hideout');
	}
}
?>