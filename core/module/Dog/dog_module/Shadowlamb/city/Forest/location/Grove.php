<?php
final class Forest_Grove extends SR_SearchRoom
{
	const KEY_RING = 'FOR_GRO_DIG_';
	
	public function getFoundPercentage() { return 20; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getSearchMaxAttemps() { return 2; }
	public function getSearchLevel() { return 18; }

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
		$rand = rand(0,99);
		
		# 10%
		if ($rand < 20)
		{
			$this->onBanshee($player);
		}
		elseif ($rand < 98)
		{
			$this->onDirt($player);
		}
		else
		{
			$this->onRing($player);
		}
		
		return true;
	}
	
	private function onBanshee(SR_Player $player)
	{
		$p = $player->getParty();
		
		$this->partyMessage($player, 'dig2', array($player->getName()));

		$nbansh = $p->getMemberCount() + rand(1, 2);
		$nbansh = Common::clamp($nbansh, 1, 6);
		
		$enemies = array('Forest_BigBanshee');
		for ($i = 0; $i < $nbansh; $i++)
		{
			$enemies[] = 'Forest_Banshee';
		}
		
		shuffle($enemies); # Legitimate use of shuffle
		
		$p->fight(SR_NPC::createEnemyParty($enemies));
	}

	private function onDirt(SR_Player $player)
	{
		$this->partyMessage($player, 'dig1', array($player->getName()));
	}

	private function onRing(SR_Player $player)
	{
		if ('1' === SR_PlayerVar::getVal($player, self::KEY_RING, '0'))
		{
			$this->onDirt($player);
		}
		else
		{
			$this->partyMessage($player, 'dig3', array($player->getName()));
			SR_PlayerVar::setVal($player, self::KEY_RING, '1');
			$player->giveItems(array(SR_Item::createByName('KylesRing')), $this->lang($player, 'from_chest'));
		}
	}
}
?>
