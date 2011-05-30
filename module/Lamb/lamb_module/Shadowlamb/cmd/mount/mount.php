<?php
final class Shadowcmd_mount extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		
		switch (count($args))
		{
			case 0: # 0 arg == inv
				return self::displayMountInv($player);
				
			case 2: # 2 arg == push|pop
				
				if ($player->isFighting())
				{
					$player->message('This does not work in combat.');
					return false;
				}
				
				switch ($args[0])
				{
					case 'push': return self::pushMountInv($player, $args[1]);
					case 'pop': return self::popMountInv($player, $args[1]);
				}
		}
		
		$bot = Shadowrap::instance($player);
		return $bot->reply(Shadowhelp::getHelp($player, 'mount'));
	}
	
	private static function displayMountInv(SR_Player $player)
	{
		$mount = $player->getMount();
		$weight = $mount->displayWeight();
		if ($weight !== '') {
			$weight = ', '.$weight;
		}
		$message = sprintf('Your %s(Class %s%s): ', $mount->getName(), $mount->getMountLockLevel(), $weight);
		return self::reply($player, $message.Shadowfunc::getMountInv($player).'.');
	}

	private static function pushMountInv(SR_Player $player, $arg)
	{
		$bot = Shadowrap::instance($player);
		
		if (false === ($item = $player->getItem($arg)))
		{
			$bot->reply('You don\'t have that item.');
			return false;
		}
		
		$mount = $player->getMount();
		$itemname = $item->getItemName();
		
		if (0 >= ($max = $mount->getMountWeight()))
		{
			$bot->reply(sprintf('You cannot store items in your %s.', $mount->getName()));
			return false;
		}
		
		if ($item instanceof SR_Mount)
		{
			$bot->reply(sprintf('You cannot put mounts in your %s.', $mount->getName()));
			return false;
		}
		
		$iw = $item->getItemWeightStacked();
		$we = $mount->calcMountWeight();
		if ( ($iw + $we) > $max )
		{
			$bot->reply(sprintf('The %s(%s) is too heavy to store in your %s(%s/%s)', $item->getName(), Shadowfunc::displayWeight($iw), $mount->getName(), Shadowfunc::displayWeight($we), Shadowfunc::displayWeight($max)));
			return false;
		}
		
		if ($item->isEquipped($player))
		{
			$player->unequip($item);
			$message = sprintf('You unequip your %s and put it in your %s.', $itemname, $mount->getName());
		}
		else 
		{
			$message = sprintf('You put your %s in your %s.', $itemname, $mount->getName());
		}
		
		$player->removeFromInventory($item);
		$player->putInMountInv($item);
		$player->modify();
		
		return $player->message($message);
	}
		
	private static function popMountInv(SR_Player $player, $arg)
	{
		$bot = Shadowrap::instance($player);
		$mount = $player->getMount();
		
		if (false === ($item = $player->removeFromMountInv($arg)))
		{
			$bot->reply(sprintf('You don\'t have that item in your %s.', $mount->getName()));
			return false;
		}
		
		$message = sprintf('You collect your %s from your %s.', $item->getItemName(), $mount->getName());
		$bot->reply($message);
		
		return true;
	}
}
?>
