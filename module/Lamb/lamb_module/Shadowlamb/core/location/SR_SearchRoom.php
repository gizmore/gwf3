<?php
abstract class SR_SearchRoom extends SR_Location
{
	public function getSearchMaxAttemps() { return 3; }
	public abstract function getSearchLevel();
	
	public function getCommands(SR_Player $player) { return array('search'); }
	
	public function on_search(SR_Player $player, array $args)
	{
		$key = $this->getTempKey();
		$attemp = $player->getTemp($key, 0);
		
		if ($attemp >= $this->getSearchMaxAttemps())
		{
			$player->message('Not again.');
			return;
		}
		
		$attemp++;
		$player->setTemp($key, $attemp);

		$loot = Shadowfunc::randLoot($player, $this->getSearchLevel());
		if (count($loot) > 0) {
			$player->message(sprintf('You search the %s...', $this->getName()));
			$player->giveItems($loot);
		} else {
			$player->message(sprintf('You search the %s... but find nothing.', $this->getName()));
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