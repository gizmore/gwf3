<?php
final class Forest_OldGraveyard extends SR_Location
{
	public function getFoundPercentage() { return 20; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getCommands(SR_Player $player)
	{
		$commands = parent::getCommands($player);
		if (false !== $player->getInvItemByName('Shovel', false, false))
		{
			$commands[] = 'dig';
		}
		return $commands;
	}

	public function on_dig(SR_Player $player, array $args)
	{
		$attempt = $this->getDigAttempt($player);
		$needAtt = $this->getNeededDigAttempts($player);
		
		$this->increaseDigAttempt($player);
		
		if ($attempt === $needAtt)
		{
			$this->onFoundRing($player);
		}
		else
		{
			$this->onRandomCombat($player);
		}
		return true;
	}
	
	private function getDigAttempt(SR_Player $player)
	{
		return (int)SR_PlayerVar::getVal($player, 'F_OG_DA_');
	}
	
	private function getNeededDigAttempts(SR_Player $player)
	{
		return 20;
	}
	
	private function increaseDigAttempt(SR_Player $player)
	{
		return SR_PlayerVar::increaseVal($player, 'F_OG_DA_', 1);
	}
	
	private function onFoundRing(SR_Player $player)
	{
		$this->partyMessage($player, 'dig2');
		$player->giveItems(array(SR_Item::createByName('IlonasRing')), $this->lang($player, 'digging'));
	}

	private function onRandomCombat(SR_Player $player)
	{
		$party = $player->getParty();
		$mc = $party->getMemberCount();
		$this->partyMessage($player, 'dig1');
		$amt = rand($mc+1, $mc+3);
		$amt = Common::clamp($amt, 1, SR_Party::MAX_MEMBERS);
		
		$possible = array('Forest_Skeleton', 'Forest_Ghoul', 'Forest_Werewolf', 'Forest_ArchElve');
		$enemies = array();
		for ($i = 0; $i < $amt; $i++)
		{
			$enemies[] = Shadowfunc::randomListItem($possible);
		}
		
		$party->fight(SR_NPC::createEnemyParty($enemies));
	}
}
?>
