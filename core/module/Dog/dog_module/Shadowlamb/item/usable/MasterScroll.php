<?php
final class Item_MasterScroll extends SR_Usable
{
	public function displayType() { return 'LvlupScroll'; }
	public function getItemWeight() { return 400; }
	public function getItemPrice() { 500.00; }
	public function getItemDescription() { return 'A magic scroll that will increase an attribute, skill or knowledge permanently.'; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->message('You cannot use this item in combat.');
			return false;
		}
		
		$bot = Shadowrap::instance($player);
		
		$mods = $this->getItemModifiersB();
		$field = key($mods);
		$level = array_shift($mods);
		
		$key = "__SLMSCR_{$field}";
		
		if (false !== SR_PlayerVar::getVal($player, $key))
		{
			return $bot->reply('You already read this master scroll.');
		}
		
		if ($player->getBase($field) < 0)
		{
			return $bot->reply("You have to learn {$field} in order to read a master scroll.");
		}
		
		if (!$this->useAmount($player, 1))
		{
			return $bot->reply('Database error!');
		}
		
		if (false === $player->increaseField($field))
		{
			return $bot->reply('Database error 2!');
		}
		
		if (false === SR_PlayerVar::setVal($player, $key, '1'))
		{
			return $bot->reply('Database error 3!');
		}
		
		return $bot->reply(sprintf('You read the %s and got your %s increased by 1.', $this->getItemName(), $field));
	}
}