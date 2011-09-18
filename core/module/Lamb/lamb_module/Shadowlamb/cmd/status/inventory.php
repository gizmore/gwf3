<?php
final class Shadowcmd_inventory extends Shadowcmd
{
	const IPP = 10;
	
	public static function execute(SR_Player $player, array $args)
	{
		$search = false;
		if (count($args) === 0)
		{
			$page = 1;
		}
		elseif (count($args) === 1)
		{
			if (is_numeric($args[0]))
			{
				$page = (int)$args[0];
			}
			else
			{
				$page = 1;
				$search = $args[0];
			}
		}
		elseif (count($args) === 2)
		{
			$search = $args[0];
			$page = Common::clamp((int)$args[1], 1);
		}
		
		return self::showInventory($player, $page, $search);
	}

	private static function showInventory(SR_Player $player, $page, $search=false)
	{
		$bot = Shadowrap::instance($player);
		$items2 = $player->getInventorySorted();
		$items = array();
		$i = 1;
		if ($search !== false)
		{
			foreach ($items2 as $itemname => $data)
			{
				$count = $data[0];
				$itemid = $data[1];
				if (stripos($itemname, $search) !== false)
				{
					$items[$i] = array($itemname, $count);
				}
				$i++;
			}
		}
		else
		{
			foreach ($items2 as $itemname => $data)
			{
				$count = $data[0];
				$itemid = $data[1];
				$items[$i++] = array($itemname, $count);
			}
		}
		
		$nPages = GWF_PageMenu::getPagecount(self::IPP, count($items));
		
		$items = array_slice($items, self::IPP*($page-1), self::IPP, true);
		
		if (count($items) === 0)
		{
			if ($page === 1)
			{
				return $bot->reply('Your inventory is empty.');
			}
			else
			{
				return $bot->reply('This page is empty.');
			}
		}
		
		$back = '';
		foreach ($items as $i => $data)
		{
			list($itemname, $count) = $data;
			$count = $count > 1 ? "($count)" : '';
			$back .= sprintf(", \X02%s\X02-%s%s", $i, $itemname, $count);
		}
		
		return $bot->reply(sprintf('Inventory page %d/%d: %s.', $page, $nPages, substr($back, 2)));
	}
}
?>
