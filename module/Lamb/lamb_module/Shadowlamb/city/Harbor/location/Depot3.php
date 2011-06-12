<?php
final class Harbor_Depot3 extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) { return 'You enter the depot. You see a lot of big crates in the hall.'; }
	public function getFoundText(SR_Player $player) { return 'You found a big Depot labeled "Depot3".'; }
	public function getFoundPercentage() { return 50.0; }
	
	public function isLocked() { return true; } 
	public function getLockLevel() { return 2.0; } # 0.0-10.0
	
	public function getSearchMaxAttemps() { return 3; }
	public function getSearchLevel() { return 8; }
	public function getSearchLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_GJohnson4');
		$quest instanceof Quest_Seattle_GJohnson4;
		return $quest->giveElectronicParts($player);
	}
	
//	public function onCrackedLock(SR_Player $player, SR_Player $cracker)
//	{
//		$party = $player->getParty();
//		$party->notice(sprintf('Four depot guards suprise you and attack.'));
//		SR_NPC::createEnemyParty('Harbor_DepotGuard','Harbor_DepotGuard','Harbor_DepotGuard','Harbor_DepotGuard')->fight($party, true);
//	}
	
	public function onEnter(SR_Player $player)
	{
		if (!parent::onEnter($player))
		{
			return false;
		}
		$party = $player->getParty();
		$party->notice(sprintf('Four depot guards suprise you and attack.'));
		SR_NPC::createEnemyParty('Harbor_DepotGuard','Harbor_DepotGuard','Harbor_DepotGuard','Harbor_DepotGuard')->fight($party, true);
		return true;
	}
}
?>