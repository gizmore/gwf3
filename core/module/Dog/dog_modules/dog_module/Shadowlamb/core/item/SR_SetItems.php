<?php
/**
 * Logic to detect set items.
 * @author gizmore
 */
final class SR_SetItems
{
	private static $SETS = array(
		'TinfoilSet' => array(
			array('defense' => 0.2),
			array('TinfoilGloves', 'TinfoilBelt', 'TinfoilCap', 'TinfoilSandals'),
		),
		
		'BikerSet' => array(
			array('defense' => 0.5),
			array('BikerJacket', 'BikerBelt', 'BikerBoots', 'BikerGloves', 'BikerHelmet', 'BikerLegs'),
		),

		'ElvenSet' => array(
			array('quickness' => 0.5, 'bows' => 6.0, 'body' => 1.0, 'strength' => 1.0),
			array('ElvenTag', array('ElvenVest', 'ElvenRobe'), 'ElvenBoots', 'ElvenGloves', 'ElvenCap', array('ElvenShorts', 'ElvenTrousers')),
		),

		'NinjaSet' => array(
			array('quickness' => 1.5, 'ninja' => 5.0, 'sharpshooter' => 6.0),
			array('NinjaCloak', 'UwaObi', 'ChikaTabi', 'Yugake', 'Hakama', array('NinjaSword', 'Ninjato', 'Ninjaken', 'KusariGama')),
		),
			
		'MagicSet' => array(
			array('spellatk' => 4.0, 'spelldef' => 1.8, 'intelligence' => 4.0),
			array(array('WizardCloak', 'WizardRobe'), 'WizardGloves', 'WizardHat'),
		),
			
		'SireneSet' => array(
			array('intelligence' => 3.0, 'spellatk' => 1.5),
			array('SireneSkin', 'SireneLegs'),
		),
			
		'DemonSet' => array(
			array('attack' => 25.0),
			array('DemonVest', 'DemonBoots', 'DemonGloves', 'DemonHelmet', 'DemonLegs', array('DemonAxe', 'DemonSword'), 'DemonShield'),
		),
	);
	
	public static function getSets() { return self::$SETS; }
	public static function getSetNames() { return array_keys(self::$SETS); }
	public static function getModifiersForSet($set) { return self::$SETS[$set][0]; }
	public static function getItemsForSet($set) { return self::$SETS[$set][1]; }
	
	public static function getSetByName($substr)
	{
		foreach (self::$SETS as $name => $set)
		{
			if (false !== stripos($name, $substr))
			{
				return $name;
			}
		}

		return false;
	}
	
	public static function getSetForItem($substr)
	{
		foreach (self::$SETS as $name => $set)
		{
			foreach ($set[1] as $items)
			{
				if (is_array($items))
				{
					foreach ($items as $item)
					{
						if (false !== stripos($item, $substr))
						{
							return $name;
						}
					}
				}
				elseif (false !== stripos($items, $substr))
				{
					return $name;
				}
			}
		}
		
		return false;
	}
	
	public static function getSetsForPlayer(SR_Player $player)
	{
		$back = array();
		foreach (self::$SETS as $set => $data)
		{
			if (self::hasSetB($player, $set, $data[1]))
			{
				$back[] = $set;
			}
		}
		return $back;
	}
	
	public static function applyModifiers(SR_Player $player)
	{
		$sets = self::getSetsForPlayer($player);
		foreach ($sets as $set)
		{
			self::applySet($player, $set);
		}
	}
	
	public static function hasSet(SR_Player $player, $set)
	{
		return self::hasSetB($player, $set, self::getItemsForSet($set));
	}
	
	private static function hasSetB(SR_Player $player, $set, array $items)
	{
		foreach ($items as $items2)
		{
			if (is_array($items2))
			{
				$false = true;
				foreach ($items2 as $item)
				{
					if (!$player->hasEquipped($item))
					{
						$false = false;
						break;
					}
				}
				if ($false)
				{
					return false;
				}
			}
			elseif (!$player->hasEquipped($items2))
			{
				return false;
			}
		}
		return true;
	}
	
	private static function applySet(SR_Player $player, $set)
	{
		$player->applyModifiers(self::getModifiersForSet($set));
	}
	
	###########################
	### Validate on startup ###
	###########################
	public static function validateSets()
	{
		foreach (self::$SETS as $set => $data)
		{
			self::validateSet($set, $data[0], $data[1]);
		}
	}
	
	private static function validateSet($set, array $mods, array $items)
	{
		foreach ($mods as $mod => $val)
		{
			if (!SR_Player::isValidModifier($mod))
			{
				die(sprintf("The ItemSet %s has an invalid bonus modifier: %s.\n", $set, $mod));
			}
		}
		
		foreach ($items as $items2)
		{
			if (is_array($items2))
			{
				foreach ($items2 as $itemname)
				{
					if (!SR_Item::exists($itemname))
					{
						die(sprintf("The ItemSet %s has an unknown item: %s.\n", $set, $itemname));
					}
				}
			}
			else
			{
				if (!SR_Item::exists($items2))
				{
					die(sprintf("The ItemSet %s has an unknown item: %s.\n", $set, $items2));
				}
			}
		}
	}
}
?>
