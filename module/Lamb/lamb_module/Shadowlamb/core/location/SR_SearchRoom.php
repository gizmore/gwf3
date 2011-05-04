<?php
abstract class SR_SearchRoom extends SR_Location
{
	public abstract function getSearchLevel();
	
	public function getCommands(SR_Player $player) { return array('search'); }
	
	public function on_search(SR_Player $player, array $args)
	{
		if (false === $player->getTemp($this->getTempKey(), false))
		{
			$player->message(sprintf('You search the %s...', $this->getName()));
			$player->giveItems(Shadowfunc::randLoot($player, $this->getSearchLevel()));
			$player->setTemp($this->getTempKey(), 1);
		}
		else
		{
			$player->message('Not again.');
		}
	}
	
	public function clearSearchCache(SR_Party $party)
	{
		$k = $this->getTempKey();
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->unsetTemp($k);
		}
	}
	
	private function getTempKey()
	{
		return $this->getName().'_search__';
	}
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
	}
}
?>