<?php
final class TrollCellar_HiddenStorage extends SR_SearchRoom
{
	public function getAreaSize() { return 6; }
	public function getSearchLevel() { return 12; }
	public function getSearchMaxAttemps() { return 1; }
	public function getFoundPercentage() { return 10.00; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function onEnter(SR_Player $player)
	{
		if (false === parent::onEnter($player))
		{
			return false;
		}
		$party = $player->getParty();
		$this->partyMessage($player, 'attack');
		
		if (false === ($ep = SR_NPC::createEnemyParty('TrollCellar_CaveTroll', 'TrollCellar_Imp', 'TrollCellar_Imp', 'TrollCellar_Imp', 'TrollCellar_Imp')))
		{
			return true;
		}
		
		$ep->fight($party);
		return true;
	}
}
?>
