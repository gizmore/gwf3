<?php
final class Shadowcmd_gmi extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'gmi'));
			return false;
		}

		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if ($target === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}

		$amount = isset($args[2]) ? (int)$args[2] : false;
		if ($amount !== false && $amount < 1)
		{
			$player->message('Please specify a positive amount.');
			return false;
		}
		
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		if (false === ($item = SR_Item::createByName($args[1],false)))
		{
			$bot->reply(sprintf('The item %s could not be created.', $args[1]));
			return false;
		}
		$items = array($item);
		
		if ($amount !== false)
		{
			if (!$item->isItemStackable())
			{
				while ($amount > 1)
				{
					$newitem = $item->createCopy();
					if ($newitem === false)
					{
						$bot->reply(sprintf('Error creating item %s; not all items will be given.', $args[1]));
						break;
					}
					$items[] = $newitem;
					$amount--;
				}
			} else {
				$item->saveVar('sr4it_amount', $amount);
			}
		}
		
		$b = chr(2);
		$target->giveItems($items, sprintf("{$b}[GM]_%s{$b}", $player->getName()));
		
		return true;
	}
}
?>
