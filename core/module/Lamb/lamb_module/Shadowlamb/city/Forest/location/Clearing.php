<?php
final class Forest_Clearing extends SR_Location
{
	const NEED_STR = 28;
	const THESWORD = 'DemonSword_of_attack:10,magic:5,melee:5';
	const SWORDKEY = 'SFC_SWORD';
	const SKELSKEY = 'SFC_SKELS';
	
	public static function getNumSkeletons(SR_Player $player)
	{
		$party = $player->getParty();
		$amt = 2 + $party->getMemberCount() * 2;
		return Common::clamp($amt, 4, SR_Party::MAX_MEMBERS);
	}
	
	public static function getNumBanshees(SR_Player $player)
	{
		$party = $player->getParty();
		$amt = 2 + $party->getMemberCount();
		return Common::clamp($amt, 3, SR_Party::MAX_MEMBERS);
	}
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player)
	{
		if ($this->isSwordStuck($player))
		{
			return $this->lang($player, 'enter2');
		}
		else
		{
			return $this->lang($player, 'enter');
		}
	}
	
	public function isSwordStuck(SR_Player $player)
	{
		return '0' === SR_PlayerVar::getVal($player, self::SWORDKEY, '0');
	}
	
	public function getCommands(SR_Player $player)
	{
		if ($this->isSwordStuck($player))
		{
			return array('pull');
		}
		else
		{
			return array();
		}
	}
	
	public function on_pull(SR_Player $player, array $args)
	{
		if ($player->get('strength') < self::NEED_STR)
		{
			$player->message($this->lang($player, 'fail'));
		}
		else
		{
			$this->onPullSword($player);
		}
	}
	
	public function onPullSword(SR_Player $player)
	{
		$p = $player->getParty();
		
		$numSkels = self::getNumSkeletons($player);
		
		$this->partyMessage($player, 'pulled1', array($player->getName()));
		$this->partyMessage($player, 'pulled2');
		$this->partyMessage($player, 'pulled3');
		$this->partyMessage($player, 'pulled4', array($numSkels));
		
		$skels = array();
		for ($i = 0; $i < $numSkels; $i++)
		{
			$skels[] = 'Forest_Skeleton';
		}
		
		SR_PlayerVar::setVal($player, self::SKELSKEY, '0');
		
		$p->fight(SR_NPC::createEnemyParty($skels));
	}
	
	public function onEnterLocation(SR_Party $party)
	{
		$player = $party->getLeader();
		if ('1' === SR_PlayerVar::getVal($player, self::SWORDKEY, '0'))
		{
			$numBansh = self::getNumBanshees($player);
			
			$this->partyMessage($player, 'magic1');
			$this->partyMessage($player, 'magic2');
			$this->partyMessage($player, 'magic3');
			
			$enemies = array('Forest_Mordak');
			for ($i = 0; $i < $numBansh; $i++)
			{
				$enemies[] = 'Forest_Banshee';
			}
			shuffle($enemies); # Legitimate use of shuffle!
			$party->fight(SR_NPC::createEnemyParty($enemies));
		}
	}
}
?>
