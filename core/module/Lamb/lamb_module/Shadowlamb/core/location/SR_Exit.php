<?php
abstract class SR_Exit extends SR_Tower
{
	public function getAbstractClassName() { return __CLASS__; }
	
	/**
	 * Get the exit location. Eg: Redmond_Hotel
	 */
	public abstract function getExitLocation();
//	public function getExitAction() { return SR_Party::ACTION_INSIDE; }
// 	public function getHelpText(SR_Player $player) { return 'You can return to this location to #leave the building.'; }
	public function getHelpText(SR_Player $player) { return $player->lang('hlp_exit'); }
	public function getLeaderCommands(SR_Player $player) { return array_merge(parent::getLeaderCommands($player), array('leave')); }
	public function getAreaSize() { return 1; }
// 	public function isExitAllowed(SR_Player $player) { return false; }
	public function on_leave(SR_Player $player, array $args)
	{
		$this->teleportOutside($player, $this->getExitLocation());
	}
}
?>