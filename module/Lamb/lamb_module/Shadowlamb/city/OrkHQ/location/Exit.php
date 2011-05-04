<?php
final class OrkHQ_Exit extends SR_Tower
{
	public function getEnterText(SR_Player $player) { return 'You enter the Ork Headquarters.'; }
	public function getHelpText(SR_Player $player) { return 'You can return to this location to #leave the building.'; }
	public function getCommands(SR_Player $player) { return array('leave'); }
	public function on_leave(SR_Player $player, array $args)
	{
		$this->teleport($player, 'Redmond_OrkHQ');
	}
}
?>