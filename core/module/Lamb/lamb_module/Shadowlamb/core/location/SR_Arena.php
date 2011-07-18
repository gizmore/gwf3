<?php
class SR_Arena extends SR_Store
{
	public function getStoreItems(SR_Player $player) { return array(); }

	/**
	 * Get available enemies. Array of array(bit, name, text).
	 * @param SR_Player $player
	 * @return array 
	 */
	public function getArenaEnemies(SR_Player $player) { return array(); }
	
	public function getCommands(SR_Player $player) { return array('challenge'); }
	
	public function getArenaKey(SR_Player $player)
	{
		return '__ARENA_'.$this->getName();
	}
	
	public function on_challenge(SR_Player $player, array $args)
	{
		$enemies = $this->getArenaEnemies($player);
		if (count($enemies) === 0)
		{
			$player->message("There is currently no enemy available.");
			return false;
		}
		
		$party = $player->getParty();
		if ($party->getMemberCount() > 1)
		{
			$player->message("You cannot challenge when you are in a party. Use #part to leave your party.");
			return false;
		}
		
		$key = $this->getArenaKey($player);
		$bits = SR_PlayerVar::getVal($player, $key, 0);
		
		foreach ($enemies as $data)
		{
			list($bit, $name, $text) = $data;
			if (!($bits & $bit))
			{
				return $this->onChallengeB($player, $bit, $name, $text);
			}
		}
		
		$player->message("You have defeated every enemy in this location.");
		return false;
	}
	
	private function onChallengeB(SR_Player $player, $bit, $name, $text)
	{
		
	}
}
?>