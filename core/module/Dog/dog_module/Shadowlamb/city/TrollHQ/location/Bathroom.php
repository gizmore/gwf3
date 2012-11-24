<?php
final class TrollHQ_Bathroom extends SR_SearchRoom
{
	public function getAreaSize() { return 14; }
	
	public function getSearchLevel() { return 4; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return "You locate a bathroom."; }
	
	public function getEnterText(SR_Player $player)
	{
		$val = SR_PlayerVar::getVal($player, 'THQFEORK', 0);
		if ($val == 0)
		{
			return $this->lang($player, 'enter1');
// 			return "You enter the bathroom. Two female Orks are dying their hair.";
		}
		else
		{
			return $this->lang($player, 'enter2');
// 			return "You enter the bathroom. It's empty beside the washing utilities.";
		}
	}
	public function getFoundPercentage() { return 50.00; }

	public function onEnter(SR_Player $player)
	{
		if (parent::onEnter($player))
		{
			$val = SR_PlayerVar::getVal($player, 'THQFEORK', 0);
			if ($val == 0)
			{
				$p = $player->getParty();
				SR_NPC::createEnemyParty('TrollHQ_FemaleOrk','TrollHQ_FemaleOrk')->talk($p);
			}
		}
		return true;
	}
}
?>
