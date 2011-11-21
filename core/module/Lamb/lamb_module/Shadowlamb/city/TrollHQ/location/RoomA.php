<?php
final class TrollHQ_RoomA extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) { return "You enter the room. Gosh, you just ran into several imps!"; }
	public function getFoundText(SR_Player $player) { return "You found another room. You hear noise from the inside, but it seems locked."; }
	public function getLockLevel() { return 1.5; }
	public function getSearchLevel() { return 9; }
	public function getFoundPercentage() { return 50.00; }
	
	public function onEnter(SR_Player $player)
	{
		if (parent::onEnter($player))
		{
			return $this->onImpAttack($player);
		}
		return false;
	}
	
	private function onImpAttack(SR_Player $player)
	{
		$party = $player->getParty();
		$mc = $party->getMemberCount();
		$min = Common::clamp($mc, 1, 4);
		$max = Common::clamp($mc*2, $mc, 8);
		$amt = rand($min, $max);
		$imps = array();
		for ($i = 0; $i < $amt; $i++)
		{
			$imps[] = 'TrollCellar_Imp';
		}
		
		SR_NPC::createEnemyParty($imps)->fight($party);
		
		return true;
	}
}
?>
