<?php
final class Seattle_Blacksmith extends SR_Blacksmith
{
	const REWARD_RUNES = 'Se_BlSm_ReRu'; 
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_BlackDwarf'); }
	public function getFoundPercentage() { return 18.00; }
	public function getFoundText(SR_Player $player) { return 'Far outside of town you find a very small store, "The Blacksmith". The store seem ruined, but it seems open.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the blacksmith. There is a poor looking dwarf behind the counter. Use #talk to talk to the poor smith.'; }
	
	public function getCommands(SR_Player $player)
	{
		$c = parent::getCommands($player);
		if ($player->hasConst(self::REWARD_RUNES))
		{
			$c[] = 'reward';
		}
		return $c;
	}
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Rune_of_strength:0.4', 100.0, 900),
			array('Rune_of_quickness:0.4', 100.0, 1400),
			array('Rune_of_melee:0.2', 100.0, 2100),
			array('Rune_of_firearms:0.2', 100.0, 2900),
			array('Rune_of_bows:0.3', 100.0, 900),
		);
	}

	public function getSimulationPrice() { return 175; }
	public function getUpgradePrice() { return 350; }
	public function getUpgradePercentPrice() { return 15.50; }
	
	public function on_reward(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply('Usage: #reward <attribute|skill>. Will create a new rune.');
			return false;
		}
		
		$f = strtolower($args[0]);
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		
		if (in_array($f, SR_Player::$SKILL)) {
			$min = 0.2;
			$max = 0.6;
		}
		elseif (in_array($f, SR_Player::$ATTRIBUTE)) {
			$min = 0.4;
			$max = 0.8;
		}
		else {
			$bot->reply('This skill or spell is unknown.');
			return false;
		}
		
		$bot->reply('The dwarf cheers and get\'s to work.');
		
		$itemname = 'Rune_of_'.$f.':'.Shadowfunc::diceFloat($min, $max, 1);
		if (false === ($item = SR_Item::createByName($itemname))) {
			$bot->reply('My smith hammer is broken!');
			return false;
		}
		
		$player->giveItems($item);
		$player->decreaseConst(Seattle_Blacksmith::REWARD_RUNES, -1);
		
		if (!$player->hasConst($key)) {
			$bot->reply('You haved used all your #reward now.');
		}
		
		return true;
	}
}
?>