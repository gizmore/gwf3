<?php
final class TrollHQ_LivingRoom extends SR_SearchRoom
{
	public function getFoundText(SR_Player $player) { return "You locate a room with a big door. You think you hear a tv, so it might be a living room."; }
	public function getFoundPercentage() { return 50.00; }
	public function getEnterText(SR_Player $player)
	{
		$c = $this->getTrollCount($player);
		if ($c === 0)
		{
			return "You enter the room. There is a lonely tv, turned up loud, but nobody is in there.";
		}
		else
		{
			return "You enter the room. You see {$c} Trolls playing cards.";
		}
	}
	
	public function getTrollCount(SR_Player $player)
	{
		$c2 = SR_PlayerVar::getVal($player, 'THQLVTRC', 0);
		if ($c2 >= 1)
		{
			return 0;
		}
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		$c = $mc * 2 + 1;
		return Common::clamp($c, 1, 10);
	}
	
	public function onEnter(SR_Player $player)
	{
		if (0 === ($count = $this->getTrollCount($player)))
		{
			return true;
		}
		$party = $player->getParty();
		
		$trolls = array();
		for ($i = 0; $i < $count; $i++)
		{
			$trolls[] = 'Delaware_Troll';
		}
		
		SR_PlayerVar::setVal($player, 'THQLVTRC', 1);
		
		SR_NPC::createEnemyParty($trolls)->fight($party);
		return true;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$player = $party->getLeader();
		SR_PlayerVar::setVal($player, 'THQLVTRC', 0);
		return parent::onCityEnter($party);
	}
}
?>
