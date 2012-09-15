<?php
require_once 'SR_Exit.php';

abstract class SR_Entrance extends SR_Exit
{
	public function getAbstractClassName() { return __CLASS__; }
	public function getHelpText(SR_Player $player) { return false; }

	public function onEnter(SR_Player $player)
	{
		if (false === parent::onEnter($player))
		{
			return false;
		}
		return $this->teleportInside($player, $this->getExitLocation());
	}
}
?>