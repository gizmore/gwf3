<?php
final class Delaware_TrollHQ extends SR_SearchRoom
{
	public function getFoundPercentage() { return 30.0; }
	public function getLockLevel() { return 0.8; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
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
