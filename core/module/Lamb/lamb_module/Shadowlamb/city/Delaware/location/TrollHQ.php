<?php
final class Delaware_TrollHQ extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) { return "You enter the huge building. It smells like rotten beef here. You hear a loud television and noises from upstairs."; }
	public function getFoundText(SR_Player $player) { return ""; }
	public function getFoundPercentage() { return 30.0; }
	public function getLockLevel() { return 0.8; }
	
	public function onEnter(SR_Player $player)
	{
		if (false === parent::onEnter($player))
		{
			return false;
		}
		return $this->teleportInside($player, 'TrollHQ_Exit');
	}
}
?>