<?php
final class Seattle_Blacksmith extends SR_Blacksmith
{
	const REWARD_RUNES = 'Se_BlSm_ReRu'; 
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_BlackDwarf'); }
	public function getFoundPercentage() { return 18.00; }
// 	public function getFoundText(SR_Player $player) { return 'Far outside of town you find a very small store, "The Blacksmith". The store seem ruined, but it seems open.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the blacksmith. There is a poor looking dwarf behind the counter. Use #talk to talk to the poor smith.'; }
	
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
		return array();
	}

	public function getSimulationPrice() { return 175; }
	public function getUpgradePrice() { return 350; }
	public function getUpgradePercentPrice() { return 15.50; }
	
	public function getUpgradeFailModifier() { return 2.8; }
	public function getUpgradeBreakModifier() { return 1.1; }
	
	public function on_reward(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply($this->lang($player, 'usage'));
// 			$bot->reply('Usage: #reward <attribute|skill>. Will create a new rune.');
			return false;
		}
		
		$f = strtolower($args[0]);
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		
		if ($f === 'essence')
		{
			$min = 0.1;
			$max = 0.1;
		}
		elseif (in_array($f, SR_Player::$SKILL))
		{
			$min = 0.2;
			$max = 0.6;
		}
		elseif (in_array($f, SR_Player::$ATTRIBUTE))
		{
			$min = 0.4;
			$max = 0.8;
		}
		else
		{
			$bot->reply($this->lang($player, 'unknown'));
// 			$bot->reply('This skill or attribute is unknown.');
			return false;
		}
		
		$itemname = 'Rune_of_'.$f.':'.Shadowfunc::diceFloat($min, $max, 1);
		if (false === ($item = SR_Item::createByName($itemname)))
		{
			$bot->reply($this->lang($player, 'broken'));
// 			$bot->reply('My smith hammer is broken!');
			return false;
		}
		
		$bot->reply($this->lang($player, 'cheers'));
// 		$bot->reply('The dwarf cheers and get\'s to work.');
		
		$bot->reply($this->lang($player, 'received', array($itemname)));
// 		$bot->reply("You received ${itemname}.");
		
		$key = self::REWARD_RUNES;
		$player->giveItems(array($item));
		$player->decreaseConst($key, -1);
		if (!$player->hasConst($key))
		{
			$bot->reply($this->lang($player, 'rewarded'));
// 			$bot->reply('You haved used all your #reward now.');
		}
		
		return true;
	}
}
?>
