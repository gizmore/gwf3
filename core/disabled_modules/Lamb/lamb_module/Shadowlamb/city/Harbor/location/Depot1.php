<?php
final class Harbor_Depot1 extends SR_SearchRoom
{
	public function getAreaSize() { return 80; }
	public function getFoundPercentage() { return 50.0; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a big Depot labeled "Depot1".'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the depot. It is mostly empty, but you see some garbage in old crates.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function isLocked() { return true; } 
	public function getLockLevel() { return 0.0; } # 0.0-10.0
	
	public function getSearchMaxAttemps() { return 1; }
	public function getSearchLevel() { return 4; }
	
	public function onEnter(SR_Player $player)
	{
		if (!parent::onEnter($player))
		{
			return false;
		}

		$party = $player->getParty();
		$this->partyMessage($player, 'suprise');
// 		$party->notice(sprintf('Two depot guards surprise you and attack.'));
		SR_NPC::createEnemyParty('Harbor_DepotGuard','Harbor_DepotGuard')->fight($party, true);
		
		return true;
	}
}
?>
