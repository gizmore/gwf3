<?php
/**
 * Display info about set items.
 * @author gizmore
 */
final class Shadowcmd_sets extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			$args = array(1);
		}
		
		if ( (count($args) === 1) && (Common::isNumeric($args[0])) )
		{
			return self::displaySets($player, (int)$args[0]);
		}
		
		elseif (count($args) === 1)
		{
			return self::displaySet($player, $args[0]);
		}
	}
	
	private static function displaySets(SR_Player $player, $page)
	{
		$ipp = 10;
		
		$sets = SR_SetItems::getSetNames();
		$nItems = count($sets);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ( ($page < 1) || ($page > $nPages) )
		{
			return $player->msg('1009');
		}
		$sets = array_slice($sets, $from, $ipp);
		
		$n = GWF_PageMenu::getFrom($page, $ipp);
		$out = '';
		$format = Shadowrun4::lang('fmt_list');
		foreach ($sets as $set)
		{
			$out .= sprintf($format, $set);
			$n++;
		}
		$out = trim($out, ',; ');
		
		return $player->msg('5295', array($page, $nPages, $out));
	}

	private static function displaySet(SR_Player $player, $substr)
	{
		if ( (false === ($set = SR_SetItems::getSetByName($substr)))
		   && (false === ($set = SR_SetItems::getSetForItem($substr)))
		)
		{
			return $player->msg('1189');
		}
		
		$modifiers = SR_SetItems::getModifiersForSet($set);
		$items = SR_SetItems::getItemsForSet($set);
		
		$modstr = '';
		$format = ', %s:%s';
		$i = $i2 = '';
		if (SR_SetItems::hasSet($player, $set))
		{
			$i = "\X02\X036";
			$i2 = "\X03\X02";
		}
		foreach ($modifiers as $key => $value)
		{
			$modstr .= sprintf($format, $key, $value);
		}
		$modstr = $i.trim($modstr, ',; ').$i2;
		
		$itemstr = '';
		$format = ', %s%s%s';
		foreach ($items as $items2)
		{
			$items2 = GWF_Array::arrify($items2);
			$pre = count($items2) > 1 ? '(' : '';
			$aft = count($items2) > 1 ? ')' : '';
			$itemstr .= $pre;
			foreach ($items2 as $itemname)
			{
				if ($player->hasEquipped($itemname))
				{
					$i = "\X02\X033";
					$i2 = "\X02\X03";
					$itename = shadowlang::displayItemNameS($itemname);
				}
				elseif (false === ($item = $player->getItemByName($itemname, false)))
				{
					 $i = "\X02\X0315";
					 $i2 = "\X02\X03";
					 $itename = shadowlang::displayItemNameS($itemname);
				}
				else
				{
					$i = $i2 = '';
					$itemname = $item->displayName($player);
				}
				$itemstr .= sprintf($format, $i, $itemname, $i2);
			}
			$itemstr .= $aft;
		}
		$itemstr = str_replace('(, ', ', (', $itemstr);
		$itemstr = trim($itemstr, ',; ');
		
		return $player->msg('5296', array($set, $itemstr, $modstr));
	}
}
?>
