<?php
abstract class SR_Blacksmith extends SR_Store
{
	public function getAbstractClassName() { return __CLASS__; }
	
	public abstract function getSimulationPrice();
	public abstract function getUpgradePrice();
	public abstract function getUpgradePercentPrice();

	public function getBreakPrice(SR_Player $player) { return 50; }
	public function getBreakPercentPrice(SR_Player $player) { return 10.00; }
	public function getCleanPrice(SR_Player $player) { return 500; }
	public function getCleanPercentPrice(SR_Player $player) { return 40.00; }
	public function getSplitPrice(SR_Player $player) { return 200; }
	public function getSplitPercentPrice(SR_Player $player) { return 35.00; }

	public function getCommands(SR_Player $player) { return array('view','viewi','buy','sell','clean','break','split','upgrade','safeupgrade'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the '.$this->getName().'. You see two dwarfs at the counter.'; }
//	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "At a blacksmith you can {$c}upgrade equipment with runes. Do {$c}simulate first if you like to see the odds. You can also {$c}break items into runes or {$c}clean them. It is also possible to {$c}split runes. Also {$c}view, {$c}buy and {$c}sell works here."; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "At a blacksmith you can {$c}upgrade equipment with runes. You can also {$c}break items into runes or {$c}clean them. It is also possible to {$c}split runes. Also {$c}view, {$c}buy and {$c}sell works here."; }
	public function getHelpText(SR_Player $player) { return $player->lang('hlp_blacksmith'); }
	public function getFoundText(SR_Player $player) { return $player->lang('stub_found_blacksmith'); }
	public function getEnterText(SR_Player $player) { return $player->lang('stub_enter_blacksmith', array($this->getCity())); }
	
	public function calcUpgradePrice(SR_Player $player, $item_price)
	{
		return Shadowfunc::calcBuyPrice(($item_price*($this->getUpgradePercentPrice()/100))+$this->getUpgradePrice(), $player);
	}

	public function calcSimulationPrice(SR_Player $player, $item_price)
	{
		return Shadowfunc::calcBuyPrice($this->getSimulationPrice(), $player);
	}

	public function calcBreakPrice(SR_Player $player, $item_price)
	{
		$price = ($item_price*($this->getBreakPercentPrice($player)/100)) + $this->getBreakPrice($player);
		return Shadowfunc::calcBuyPrice($price, $player);
	}

	public function calcCleanPrice(SR_Player $player, $item_price)
	{
		return Shadowfunc::calcBuyPrice(($item_price*($this->getCleanPercentPrice($player)/100))+$this->getCleanPrice($player), $player);
	}

	public function calcSplitPrice(SR_Player $player, $item_price)
	{
		return Shadowfunc::calcBuyPrice(($item_price*($this->getSplitPercentPrice($player)/100))+$this->getSplitPrice($player), $player);
	}

	#############
	### Clean ###
	#############
	private static $CLEAN_CONFIRM = array();
	
	public function on_clean(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'clean'));
			return false;
		}
		if (false === ($item = $player->getItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!($item instanceof SR_Equipment))
		{
			$bot->rply('1158');
			return false;
		}
		if (!$item->isItemStatted())
		{
			$bot->rply('1188');
// 			$bot->reply('You can only clean statted items.');
			return false;
		}
		
		$itemname = $item->getItemName();
		$price = $this->calcCleanPrice($player, $item->getItemPriceStatted());
		
		if (!$player->hasNuyen($price))
		{
			$bot->rply('1063', array($p, $player->displayNuyen()));
			return false;
		}
		
		
		# Confirm
		$uid = $player->getUID();
		if ($args[0] !== $itemname)
		{
			if ( (!isset(self::$CLEAN_CONFIRM[$uid])) || (self::$CLEAN_CONFIRM[$uid] !== $args[0]) )
			{
				$bot->reply(sprintf('You plan to clean your %s. Please retype to confirm.', $itemname));
				self::$CLEAN_CONFIRM[$uid] = $args[0];
				return false;
			}
			else
			{
				unset(self::$CLEAN_CONFIRM[$uid]);
			}
		}

		$p = Shadowfunc::displayNuyen($price);
		if (false === ($player->pay($price)))
		{
			$bot->rply('1063', array($p, $player->displayNuyen()));
// 			$bot->reply(sprintf('The employee shakes his head: "Nono, it will cost %s to clean this item. You only have %s."', $p, $player->displayNuyen()));
			return false;
		}

		if (false === $item->saveVar('sr4it_modifiers', NULL)) {
			$bot->reply('DB Error!');
		}

		$item->initModifiersB();
		$player->modify();

		$bot->rply('5208', array($p, $itemname, $item->getItemName()));
// 		$bot->reply("You pay {$p} and the smith cleans the {$itemname} from all it's runes. You receive a(n): ".$item->getItemName().'.');

		return true;

	}

	#############
	### Break ###
	#############
	private static $BREAK_CONFIRM = array();

	/**
	 * Destroy an item to release it's B modifiers.
	 * @param SR_Player $player
	 * @param array $args
	 * @return boolean
	 */
	public function on_break(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'break'));
			return false;
		}
		if (false === ($item = $player->getInvItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!$item->isItemStatted())
		{
			$bot->rply('1159');
// 			$bot->reply('You can only break statted items.');
			return false;
		}
// 		if ($item instanceof SR_Rune)
// 		{
// 			$bot->reply('You cannot break runes.');
// 			return false;
// 		}
		if (!($item instanceof SR_Equipment))
		{
			$bot->rply('1158');
// 			$bot->reply('You can only break equipment.');
			return false;
		}
		
		$itemname = $item->getItemName();
		
		$price = $this->calcBreakPrice($player, $item->getItemPriceStatted());
		$p = Shadowfunc::displayNuyen($price);
		if (false === ($player->hasNuyen($price)))
		{
			$bot->rply('1063', array($p, $player->displayNuyen()));
// 			$bot->reply(sprintf('The employee shakes his head: "Nono, it will cost %s to break this item. You only have %s."', $p, $player->displayNuyen()));
			return false;
		}

		# Confirm (thx jjk)
		$uid = (int)$player->getID();
		if ($args[0] !== $itemname)
		{
			if ( (!isset(self::$BREAK_CONFIRM[$uid])) || (self::$BREAK_CONFIRM[$uid] !== $args[0]) )
			{
				$bot->reply(sprintf('You plan to break your %s into rune(s). Please retype to confirm.', $itemname));
				self::$BREAK_CONFIRM[$uid] = $args[0];
				return false;
			}
			else
			{
				unset(self::$BREAK_CONFIRM[$uid]);
			}
		}
		
		if (false === $player->giveNuyen(-$price))
		{
			$player->message('DB ERROR 12');
			return false;
		}
		
		
		$modifiers = $item->getItemModifiersB();
		//		$item->saveVar('sr4it_modifiers', NULL);
		//		$item->initModifiersB();

		if ($item->isEquipped($player))
		{
			$player->unequip($item);
			$player->modify();
		}
		$item->deleteItem($player);

		$runestr = '';
		$runes = array();
		foreach ($modifiers as $k => $v)
		{
			$luck = $player->get('luck');
			$luck = Common::clamp($luck, 0, 20);
			$min_multi = 0.45 + $luck * 0.01;
			$min = round($v * $min_multi, 1);
			$max = round($v-0.1, 1);
			$v = Shadowfunc::diceFloat($min, $max, 1);
			//			$v -= 0.2;
			if ($v <= 0.01) { continue; }
				
			$rn = sprintf('Rune_of_%s:%s', $k, $v);
			if (false === ($rune = SR_Item::createByName($rn))) {
				continue;
			}
			$runes[] = $rune;
			$runestr .= ', '.$rn;
		}
		if (count($runes) > 0)
		{
			$bot->rply('5209', array($p, $itemname, substr($runestr, 2)));
// 			$bot->reply(sprintf('You pay %s and break the %s into %s.', $p, $itemname, substr($runestr, 2)));
			$player->giveItems($runes);
		}
		else
		{
			$bot->rply('5210', array($p, $itemname));
// 			$bot->reply(sprintf('You pay %s but breaking the %s into runes failed.', $p, $itemname));
		}
		$player->modify();
		return true;
	}

	##########################
	### Upgrade / Simulate ###
	##########################
	private static $UPGRADE_CONFIRM = array();
	public function on_upgrade(SR_Player $player, array $args) { return $this->onUpgradeB($player, $args, false); }
	public function on_safeupgrade(SR_Player $player, array $args) { return $this->onUpgradeB($player, $args, true); }
	
	public function onUpgradeB(SR_Player $player, array $args, $safe)
	{
		$pid = $player->getID();
		$safebit = $safe ? 'X' : 'Y';
		$old_msg = isset(self::$UPGRADE_CONFIRM[$pid.$safebit]) ? self::$UPGRADE_CONFIRM[$pid.$safebit] : '';
		unset(self::$UPGRADE_CONFIRM[$pid.$safebit]);
		
		$bot = Shadowrap::instance($player);
		if (count($args) !== 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'upgrade'));
			return false;
		}

		if (false === ($item = $player->getItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		if ( (!($item instanceof SR_Equipment)) || (!($item->isItemStattable())) )
		{
			$bot->rply('1158');
// 			$bot->reply('The first item is not an equipment.');
			return false;
		}
		if (false === ($rune = $player->getInvItem($args[1])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that rune.');
			return false;
		}
		if (!($rune instanceof SR_Rune))
		{
			$bot->rply('1160');
// 			$bot->reply('The second item is not a rune.');
			return false;
		}

		$modsRune = $rune->getModifiers();
		if (($modsRune === NULL) || (count($modsRune) === 0))
		{
			$bot->reply('The rune has no modifiers. Somethings wrong! (BUG)');
			return false;
		}

		if (!$this->checkCombination($player, $item, $rune))
		{
// 			$bot->rply('1161');
// 			$bot->reply('This item can not get this rune applied to it.');
			return false;
		}
		
		# Check if equipped mount is loaded with items. (thx tehron)
		if ($item instanceof SR_Mount)
		{
			if ($item->isEquipped($player))
			{
				if (count($player->getMountInvSorted()) !== 0)
				{
					$bot->rply('1164');
// 					$bot->reply("Please '#mount clean' before you '#upgrade' it.");
					return false;
				}
			}
		}
		
		if (false === SR_Item::canMergeModifiersLength($item, $rune))
		{
			$bot->rply('1165');
// 			$bot->reply('The item string would get too long with another modifier.');
			return false;
		}

		$mods = SR_Item::mergeModifiers($item->getItemModifiersB(), $rune->getItemModifiersB());
		
		$luck = $player->get('luck');
		$luck = Common::clamp($luck, 0, 30);
		$luckmod = 0.35;
		$luckmod -= $luck * 0.005;
		$fail = SR_Rune::calcFailChance($mods)*$luckmod*3.0;
		$break = SR_Rune::calcBreakChance($mods)*$luckmod*1.2;
		$price_u = $this->calcUpgradePrice($player, $rune->getItemPriceStatted());
		$dpu = Shadowfunc::displayNuyen($price_u);
		
		$fail = round(Common::clamp($fail, 5, 85), 2);
		$break = round(Common::clamp($break, 1, 50), 2);
		
		if ($safe)
		{
			$fail -= 5;
			$break = 0;
		}
		
		## Confirm
		$msg = implode(' ', $args);
		if ($msg !== $old_msg)
		{
			self::$UPGRADE_CONFIRM[$pid.$safebit] = $msg;
			return $player->msg('5211', array(
				Shadowfunc::displayNuyen($price_u), $item->getItemName(), $rune->getItemName(), $fail, $break
			));
// 			return $player->message(sprintf(
// 				'The smith examines your items ... "It would cost you %s to upgrade your %s with %s. The fail chance is %.02f%% and the break chance is %.02f%%. Please retype to confirm.',
// 				Shadowfunc::displayNuyen($price_u), $item->getItemName(), $rune->getItemName(), $fail, $break
// 			));
		}
		
		if (!$player->hasNuyen($price_u))
		{
			$bot->rply('1063', array($dpu, $player->displayNuyen()));
// 			$bot->reply(sprintf('The smith says: "I am sorry chummer, the upgrade would cost you %s."', $dpu));
			return false;
		}
		
		# Safe mode
		if ($safe)
		{
			$break = 0;
			if (false === ($oil = $player->getInvItemByName('MagicOil')))
			{
				$bot->rply('1187', array(Shadowlang::displayItemNameS('MagicOil')));
				return false;
			}
			if (!$oil->useAmount($player, 1))
			{
				$bot->reply('DB Error 19');
				return false;
			}
		}

			
			
		$player->msg('5212');
// 		$player->message('The smith takes your items and goes to work...');
		$player->removeItem($rune);
			
		if (Shadowfunc::dicePercent($fail))
		{
			if (Shadowfunc::dicePercent($break))
			{
				$player->removeItem($item);
				$bot->rply('5213', array($item->getItemName(), $rune->getItemName()));
// 				$bot->reply(sprintf('The upgrade horrible failed and the item and the rune is lost. The smith is very sorry and you don`t need to pay any money.'));
			}
			else
			{
				$price_f = $this->calcUpgradePrice($player, 0);
				$player->pay($price_f);
				$dpf = Shadowfunc::displayNuyen($price_f);
				$bot->rply('5214', array($dpf, $rune->getItemName()));
// 				$bot->reply(sprintf('The upgrade failed and the rune is lost. You only need to pay %s for the work.', $dpf));
			}
		}
		else
		{
			$player->pay($price_u);
			$old_name = $item->displayFullName($player);
			$item->addModifiers($rune->getItemModifiersB(), true);
			$item->addModifiers($rune->getItemModifiersA($player), true);
			$bot->rply('5215', array($dpu, $item->displayFullName($player), $old_name, $rune->displayFullName($player)));
// 			$bot->reply(sprintf('The upgrade succeeded. You pay %s and the smith presents you a fine %s.', $dpu, $item->getItemName()));
		}
			
		$player->modify();
			
		return true;
	}
	
	private function checkCombination(SR_Player $player, SR_Item $item, SR_Rune $rune)
	{
		if ($rune->isMixedRune())
		{
			$player->msg('1161');
// 			$player->message('The rune has mixed mount and equipment modifiers. You have to split it first.');
			return false;
		}
	
		$mr = $rune->isMountRune();
	
		if ($rune->isMountRune())
		{
			if (!($item instanceof SR_Mount))
			{
				$player->msg('1162');
// 				$player->message('This rune can only be applied to mounts.');
				return false;
			}
		}
		else
		{
			if (!$item->isItemStattable())
			{
				$player->msg('1163');
// 				$player->message('This rune can only be applied to equipment.');
				return false;
			}
		}
	
		return true;
	}
	
	#############
	### Split ###
	#############
	private static $SPLIT_CONFIRM = array();
	public function on_split(SR_Player $player, array $args)
	{
		# Bailout
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'split'));
			return false;
		}
	
		# Get Item
		if (false === ($rune = $player->getItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		$pid = $player->getID();
		$itemname = $rune->getItemName();
		$confirmed = ( (isset(self::$SPLIT_CONFIRM[$pid])) && (self::$SPLIT_CONFIRM[$pid]===$rune->getID()) );
		unset(self::$SPLIT_CONFIRM[$pid]);
	
		if (!($rune instanceof SR_Rune))
		{
			$bot->rply('1166');
// 			$bot->reply('You can only split runes.');
			return false;
		}
		$mods = array_merge($rune->getItemModifiersA($player), $rune->getItemModifiersB());
		if (count($mods) < 2)
		{
			$bot->rply('1167');
// 			$bot->reply('This rune has only one modifier.');
			return false;
		}
	
		# Check price
		$price = $this->calcSplitPrice($player, $rune->getItemPriceStatted());
		$dp = Shadowfunc::displayNuyen($price);
		if (!$player->hasNuyen($price))
		{
			$bot->rply('1063', array($dp, $player->displayNuyen()));
// 			$player->message(sprintf('It would cost %s to split the %s, but you only have %s.', $dp, $itemname, $player->getNuyen()));
			return false;
		}
	
		# Confirm?
		if (!$confirmed)
		{
			self::$SPLIT_CONFIRM[$pid] = $rune->getID();
			$bot->rply('5216', array($dp, $itemname));
// 			$player->message(sprintf('It would cost %s to split the %s. Retype your command to confirm.', $dp, $itemname));
			return true;
		}
	
		$runes = array();
		$names = array();
		$mods = array_merge($rune->getItemModifiersA($player), $rune->getItemModifiersB());
		foreach ($mods as $k => $v)
		{
			$v /= 2;
			$v += Shadowfunc::diceFloat(0.0, $v/2, 1);
			$v = round($v, 1);
				
			if ($v >= 0.1)
			{
				$name = "Rune_of_{$k}:{$v}";
				$runes[] = SR_Item::createByName($name);
				$names[] = $name;
			}
		}
	
		if (false === $rune->deleteItem($player))
		{
			$bot->reply(sprintf('Cannot delete rune in %s line %s.', __FILE__, __LINE__));
			return false;
		}
	
		if (count($runes) === 0)
		{
			$bot->rply('1168');
// 			$bot->reply(sprintf('The rune burned into dust while splitting it. You don\'t need to pay.'));
			return true;
		}
	
		if (false === $player->giveItems($runes))
		{
			$bot->reply(sprintf('Cannot give items in %s line %s.', __FILE__, __LINE__));
			return false;
		}
	
		if (false === $player->pay($price))
		{
			$bot->reply(sprintf('Cannot pay price in %s line %s.', __FILE__, __LINE__));
			return false;
		}
	
		return $bot->rply('5217', array($dp, $itemname, GWF_Array::implodeHuman($names)));
// 		return $bot->reply(sprintf('You pay %s and split your %s into %s.', $dp, $itemname, GWF_Array::implodeHuman($names)));
	}
	
	public function onEnterLocation(SR_Party $party)
	{
		foreach ($party->getMembers() as $player)
		{
			$pid = $player->getID();
			unset(self::$UPGRADE_CONFIRM[$pid.'X']);
			unset(self::$UPGRADE_CONFIRM[$pid.'Y']);
			unset(self::$SPLIT_CONFIRM[$pid]);
			unset(self::$BREAK_CONFIRM[$pid]);
		}
	}
}
?>
