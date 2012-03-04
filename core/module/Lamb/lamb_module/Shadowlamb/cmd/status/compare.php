<?php
/**
 * Compare two items with each other.
 * @author digitalseraphim
 * @since Shadowlamb 3.1
 */
final class Shadowcmd_compare extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$numArgs = count($args);

		if ($numArgs < 1 || $numArgs > 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'compare'));
			return false;
		}

		$item1 = self::getItem($bot, $player, $args[0]);

		if(!$item1)
		{
			self::rply($player, '1020', array($args[0]));
// 			$bot->reply('I don`t know what item "'.$args[0].'" is.');
			return false;
		}
		
		if($numArgs > 1)
		{
			$item2 = self::getItem($bot, $player, $args[1]);
			if(!$item2)
			{
				self::rply($player, '1020', array($args[1]));
// 				$bot->reply('I don`t know what item "'.$args[1].'" is.');
				return false;
			}
		}else{
			$item2 = $player->getItem( $item1->getItemType() );
			if(!$item2)
			{
				self::rply($player, '1021', array($item1->getItemName()));
// 				$bot->reply('You don`t have anything comparable to "'.$item1->getItemName().'" equipped');
				return false;
			}
		}
		$bot->replyTable(self::getComparisonMatrix($player, $item1, $item2), '5043');
		return true;
	}

	private static function getComparisonMatrix($player, $item1, $item2)
	{
		$titles=array();
		$item1Stuff=array();
		$item2Stuff=array();
		$b = chr(2);

		$type = $item1->getItemType();

		$titles[] = 'Type';
		$item1Stuff[] = str_replace(" Weapon","",$player->lang($item1->displayType()));
		$item2Stuff[] = str_replace(" Weapon","",$player->lang($item2->displayType()));

		$titles[] = 'Lvl';
		$item1Lvl = $item1->getItemLevel();
		$item2Lvl = $item2->getItemLevel();
		if($item1Lvl == $item2Lvl)
		{
			$item1Stuff[] = $b.$item1Lvl.$b;
			$item2Stuff[] = $b.$item2Lvl.$b;
		}
		else if($item2Lvl > $item1Lvl)
		{
			$item1Stuff[] = $item1Lvl;
			$item2Stuff[] = $b.$item2Lvl.$b;
		}
		else
		{
			$item1Stuff[] = $b.$item1Lvl.$b;
			$item2Stuff[] = $item2Lvl;
		}
		
		$item1ModA = $item1->getItemModifiersA($player);
		$item2ModA = $item2->getItemModifiersA($player);

		if($item1ModA || $item2ModA)
		{
			if(array_key_exists('min_dmg', $item1ModA) || array_key_exists('min_dmg', $item2ModA))
			{
				$titles[] = 'dmg';
				$item1min = false;
				$item1max = false;
				$item2min = false;
				$item2max = false;
				if(array_key_exists('min_dmg', $item1ModA))
				{
					$item1min = $item1ModA['min_dmg'];
					$item1max = $item1ModA['max_dmg'];
					unset($item1ModA['min_dmg']);
					unset($item1ModA['max_dmg']);
				}
				if(array_key_exists('min_dmg', $item2ModA))
				{
					$item2min = $item2ModA['min_dmg'];
					$item2max = $item2ModA['max_dmg'];
					unset($item2ModA['min_dmg']);
					unset($item2ModA['max_dmg']);
				}

				if($item1min == $item2min)
				{
					$item1min = $b.$item1min.$b;
					$item2min = $b.$item2min.$b;
				}
				else if($item1min > $item2min)
				{
					$item1min = $b.$item1min.$b;
				}
				else
				{
					$item2min = $b.$item2min.$b;
				}
				if($item1max == $item2max)
				{
					$item1min = $b.$item1min.$b;
					$item2min = $b.$item2min.$b;
				}
				else if($item1max > $item2max)
				{
					$item1max = $b.$item1max.$b;
				}
				else
				{
					$item2max = $b.$item2max.$b;
				}
				
				if($item1max)
				{
					$item1Stuff[] = $item1min.'-'.$item1max;
				}
				else
				{
					$item1Stuff[] = "";
				}
				if($item2max)
				{
					$item2Stuff[] = $item2min.'-'.$item2max;
				}
				else
				{
					$item2Stuff[] = "";
				}
			}

			$keys = array_unique(array_merge(array_keys($item1ModA?$item1ModA:array()), 
			                                 array_keys($item2ModA?$item2ModA:array())));
			foreach($keys as $k => $v)
			{
				$titles[] = Shadowfunc::longModifierToShort($v);
				$item1V = ($item1ModA&&array_key_exists($v,$item1ModA))?$item1ModA[$v]:false; 
				$item2V = ($item2ModA&&array_key_exists($v,$item2ModA))?$item2ModA[$v]:false;

				if($item1V && $item2V && ($item1V == $item2V))
				{
					$item1V = $b.$item1V.$b;
					$item2V = $b.$item2V.$b;
				}
				else if(!$item1V || $item2V > $item1V)
				{
					$item2V = $b.$item2V.$b;
				}
				else if(!$item2V || $item1V > $item2V)
				{
					$item1V = $b.$item1V.$b;
				}

				$item1Stuff[] = $item1V;
				$item2Stuff[] = $item2V;
			}
		}
		
		$item1ModB = $item1->getItemModifiersB();
		$item2ModB = $item2->getItemModifiersB();

		if($item1ModB || $item2ModB)
		{
			$keys = array_unique(array_merge(array_keys($item1ModB?$item1ModB:array()), array_keys($item2ModB?$item2ModB:array())));
			foreach($keys as $k => $v){
				$titles[] = Shadowfunc::longModifierToShort($v);
				$item1V = ($item1ModB&&array_key_exists($v,$item1ModB))?$item1ModB[$v]:false; 
				$item2V = ($item2ModB&&array_key_exists($v,$item2ModB))?$item2ModB[$v]:false;

				if($item1V && $item2V && ($item1V == $item2V))
				{
					$item1V = $b.$item1V.$b;
					$item2V = $b.$item2V.$b;
				}
				else if(!$item1V || $item2V > $item1V)
				{
					$item2V = $b.$item2V.$b;
				}
				else if(!$item2V || $item1V > $item2V)
				{
					$item1V = $b.$item1V.$b;
				}
				
				$item1Stuff[] = $item1V;
				$item2Stuff[] = $item2V;
			}
		}

		$item1Reqs = $item1->getItemRequirements();
		$item2Reqs = $item2->getItemRequirements();
		if($item1Reqs || $item2Reqs){
			$titles[] = 'Reqs';
			$keys = array_unique(array_merge(array_keys($item1Reqs?$item1Reqs:array()), array_keys($item2Reqs?$item2Reqs:array())));
			$samekeys = array_intersect(array_keys($item1Reqs?$item1Reqs:array()), array_keys($item2Reqs?$item2Reqs:array()));
			$item1V = array();
			$item2V = array();
			
			foreach($samekeys as $key)
			{
				unset($keys[$key]);
				$req = Shadowfunc::longModifierToShort($key);
				$item1R = $item1Reqs[$key];
				$item2R = $item2Reqs[$key];

				if($item1R == $item2R)
				{
					$item1V[] = $req.":".$b.$item1R.$b;
					$item2V[] = $req.":".$b.$item2R.$b;
				}
				else if($item1R > $item2R)
				{
					$item1V[] = $req.":".$b.$item1R.$b;
					$item2V[] = $req.":".$item2R;
				}
				else
				{
					$item1V[] = $req.":".$item1R;
					$item2V[] = $req.":".$b.$item2R.$b;
				}
			}

			foreach($keys as $key)
			{
				$req = Shadowfunc::longModifierToShort($key);
				$item1R = false;
				$item2R = false;
				if(array_key_exists($key, $item1Reqs))
				{
					$item1R = $item1Reqs[$key];
				}
				if(array_key_exists($key, $item2Reqs))
				{
					$item2R = $item2Reqs[$key];
				}

				if($item1R)
				{
					$item1V[] = $req.":".$b.$item1R.$b;
					$item2V[] = $req.":".'0';
				}
				else
				{
					$item1V[] = $req.":".'0';
					$item2V[] = $req.":".$b.$item2R.$b;
				}
			}

			$item1Stuff[] = implode(',',$item1V);
			$item2Stuff[] = implode(',',$item2V);
		}

		$item1Rng = $item1->getItemRange();
		$item2Rng = $item2->getItemRange();

		if($item1Rng > 0 || $item2Rng > 0)
		{
			$titles[] = 'Rng';
			if($item1Rng == $item2Rng)
			{
				$item1Stuff[] = $b.$item1Rng.$b;
				$item2Stuff[] = $b.$item2Rng.$b;
			}
			else if($item2Rng > $item1Rng)
			{
				$item1Stuff[] = $item1Rng;
				$item2Stuff[] = $b.$item2Rng.$b;
			}
			else
			{
				$item1Stuff[] = $b.$item1Rng.$b;
				$item2Stuff[] = $item2Rng;
			}
		}
		
		$titles[] = 'Wgt';
		$item1Wgt = $item1->getItemWeight();
		$item2Wgt = $item2->getItemWeight();
		if($item1Wgt == $item2Wgt)
		{
			$item1Stuff[] = $b.$item1Wgt.'g'.$b;
			$item2Stuff[] = $b.$item2Wgt.'g'.$b;
		}
		else if($item2Wgt < $item1Wgt) //NOTE:: This test is opposite from other tests
		{                              // because lower item weight is better!
			$item1Stuff[] = $item1Wgt.'g';
			$item2Stuff[] = $b.$item2Wgt.'g'.$b;
		}
		else
		{
			$item1Stuff[] = $b.$item1Wgt.'g'.$b;
			$item2Stuff[] = $item2Wgt.'g';
		}
		
		$titles[] = 'Worth';
		$item1Prc = $item1->getItemPrice();
		$item2Prc = $item2->getItemPrice();
		if($item1Prc == $item2Prc)
		{
			$item1Stuff[] = $b.Shadowfunc::displayNuyen($item1Prc).$b;
			$item2Stuff[] = $b.Shadowfunc::displayNuyen($item2Prc).$b;
		}
		else if($item2Prc > $item1Prc)
		{
			$item1Stuff[] = Shadowfunc::displayNuyen($item1Prc);
			$item2Stuff[] = $b.Shadowfunc::displayNuyen($item2Prc).$b;
		}
		else
		{
			$item1Stuff[] = $b.Shadowfunc::displayNuyen($item1Prc).$b;
			$item2Stuff[] = Shadowfunc::displayNuyen($item2Prc);
		}
		
		return array(Shadowrun4::lang('name') => $titles, $item1->getItemName() => $item1Stuff, $item2->getItemName() => $item2Stuff);
	}

	private static function getItem($bot, SR_Player $player, $itemid)
	{
		if (preg_match('/^S_[0-9]+$/D', $itemid))
		{
			$location = $player->getParty()->getLocationClass(SR_Party::ACTION_INSIDE);
			if ($location !== false && $location instanceof SR_Store)
			{
				return $location->getStoreItem($player, substr($itemid,2));
			}
			else
			{
				self::rply($player, '1022');
// 				$bot->reply('You are not in a store!');
			}
			return false;
		}
		else
		{
			return $player->getItem($itemid);
		}
	}
}
?>
