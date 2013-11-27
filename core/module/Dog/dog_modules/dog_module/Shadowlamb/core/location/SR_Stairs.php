<?php
require_once 'SR_Entrance.php';

abstract class SR_Stairs extends SR_Entrance
{
	public function onEnter(SR_Player $player)
	{
		if (false === parent::onEnter($player))
		{
			return false;
		}
		return $this->teleportOutside($player, $this->getExitLocation());
	}
}
?>