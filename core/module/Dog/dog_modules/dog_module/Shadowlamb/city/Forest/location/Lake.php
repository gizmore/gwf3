<?php
final class Forest_Lake extends SR_SearchRoom
{
	public function getFoundPercentage() { return 30; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	public function getAreaSize() { return 40; }
	
	public function getSearchMaxAttemps() { return 2; }
	public function getSearchLevel() { return 28; }
	public function getSearchChanceNone() { return 4.50; }
	
	public function getCommands(SR_Player $player)
	{
		$commands = parent::getCommands($player);
		$commands[] = 'grab';
		return $commands;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$party->unsetTemp('FORLAKGRB');
		
	}
	
	public function on_grab(SR_Player $player, array $args)
	{
		if ($player->getParty()->hasTemp('FORLAKGRB'))
		{
			$this->partyMessage($player, 'grab_twice');
			return true;
		}
		elseif (rand(0,3) === 3)
		{
			$player->getParty()->setTemp('FORLAKGRB', 1);
			$this->partyMessage($player, 'grab2', array($player->getName()));
			$this->onSparkleItem($player);
		}
		else
		{
			$this->partyMessage($player, 'grab1', array($player->getName()));
		}

		$numSirenes = self::getNumSirenes($player);
		$enemies = array();
		for ($i = 0; $i < $numSirenes; $i++)
		{
			$enemies[] = 'Forest_Sirene';
		}
		
		$player->getParty()->fight(SR_NPC::createEnemyParty($enemies));
		
		return true;
	}
	
	private static function getNumSirenes(SR_Player $player)
	{
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		return Common::clamp(rand(2, 3+$mc), 2, 8);
	}
	
	private function onSparkleItem(SR_Player $player)
	{
		$items = array(
			'Ring',
			'Amulet',
			'Earring',
			'LO_Ring',
			'Knife',
			'Stiletto',
			'TinfoilCap',
			'TinfoilBelt',
			'TinfoilSandals',
		);
		
		$iname = Shadowfunc::randomListItem($items);
		
		if (false === ($item = SR_Item::createByName($iname)))
		{
			$player->message('DB Error 4');
			return false;
		}
		
		return $player->giveItems(array($item), $this->lang($player, 'from_lake'));
	}
}
?>
