<?php
final class Forest_Clearing extends SR_Location
{
	const NEED_STR = 35;
	const THESWORD = 'DemonSword_of_attack:10,magic:5,melee:5';
	const SWORDKEY = 'SFC_SWORD';
	
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
		
		if (!$player->giveItem(SR_Item::createByName(self::THESWORD)))
		{
			return false;
		}
		
		$this->partyMessage($player, 'pulled', array($player->getName()));
		
		SR_PlayerVar::setVal($player, self::SWORDKEY, '1');
		
		$p->fight(SR_NPC::createEnemyParty('Forest_Ghost','Forest_Ghost','Forest_Ghost','Forest_Ghost','Forest_Ghost'));
		
	}
}
?>
