<?php
abstract class SR_Blacksmith extends SR_Store
{
	public abstract function getSimulationPrice();
	public abstract function getUpgradePrice();
	public abstract function getUpgradePercentPrice();

	public function getBreakPrice(SR_Player $player) { return 50; }
	public function getBreakPercentPrice(SR_Player $player) { return 10.00; }
	public function getCleanPrice(SR_Player $player) { return 500; }
	public function getCleanPercentPrice(SR_Player $player) { return 40.00; }
	public function getSplitPrice(SR_Player $player) { return 200; }
	public function getSplitPercentPrice(SR_Player $player) { return 35.00; }

	public function getCommands(SR_Player $player) { return array('view','buy','sell','clean','break','split'/*,'simulate'*/,'upgrade'); }
	public function getEnterText(SR_Player $player) { return 'You enter the '.$this->getName().'. You see two dwarfs at the counter.'; }
	//	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "At a blacksmith you can {$c}upgrade equipment with runes. Do {$c}simulate first if you like to see the odds. You can also {$c}break items into runes or {$c}clean them. It is also possible to {$c}split runes. Also {$c}view, {$c}buy and {$c}sell works here."; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "At a blacksmith you can {$c}upgrade equipment with runes. You can also {$c}break items into runes or {$c}clean them. It is also possible to {$c}split runes. Also {$c}view, {$c}buy and {$c}sell works here."; }

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
		return Shadowfunc::calcBuyPrice(($item_price*($this->getBreakPercentPrice($player)/100))+$this->getBreakPrice($player), $player);
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
	public function on_clean(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'clean'));
			return false;
		}
		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!$item->isItemStatted()) {
			$bot->reply('You can only clean statted items.');
			return false;
		}
		if ($item instanceof SR_Rune) {
			$bot->reply('You cannot clean runes.');
			return false;
		}

		$itemname = $item->getItemName();
		$price = $this->calcCleanPrice($player, $item->getItemPriceStatted());

		$p = Shadowfunc::displayNuyen($price);
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('The employee shakes his head: "Nono, it will cost %s to clean this item. You only have %s."', $p, $player->displayNuyen()));
			return false;
		}

		if (false === $item->saveVar('sr4it_modifiers', NULL)) {
			$bot->reply('DB Error!');
		}

		$item->initModifiersB();
		$player->modify();

		$bot->reply("You pay {$p} and the smith cleans the {$itemname} from all it's runes. You receive a(n): ".$item->getItemName().'.');

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
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'break'));
			return false;
		}
		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!$item->isItemStatted()) {
			$bot->reply('You can only break statted items.');
			return false;
		}
		if ($item instanceof SR_Rune) {
			$bot->reply('You cannot break runes.');
			return false;
		}
		
		$itemname = $item->getItemName();
		
		$price = $this->calcBreakPrice($player, $item->getItemPriceStatted());
		$p = Shadowfunc::displayNuyen($price);
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('The employee shakes his head: "Nono, it will cost %s to break this item. You only have %s."', $p, $player->displayNuyen()));
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
			$min = round($v/2, 1);
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
			$bot->reply(sprintf('You pay %s and break the %s into %s.', $p, $itemname, substr($runestr, 2)));
			$player->giveItems($runes);
		}
		else
		{
			$bot->reply(sprintf('You pay %s but breaking the %s into runes failed.', $p, $itemname));
		}
		$player->modify();
		return true;
	}

	##########################
	### Upgrade / Simulate ###
	##########################
	private static $UPGRADE_CONFIRM = array();
	public function on_upgrade(SR_Player $player, array $args) { return $this->onUpgrade($player, $args, false); }
	//	public function on_simulate(SR_Player $player, array $args) { return $this->onUpgrade($player, $args, true); }
	private function onUpgrade(SR_Player $player, array $args, $simulated=false)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 2) {
			$bot->reply(Shadowhelp::getHelp($player, $simulated?'simulate':'upgrade'));
			return false;
		}

		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!($item instanceof SR_Equipment)) {
			$bot->reply('The first item is not an equipment.');
			return false;
		}
		if (false === ($rune = $player->getItem($args[1]))) {
			$bot->reply('You don`t have that rune.');
			return false;
		}
		if (!($rune instanceof SR_Rune)) {
			$bot->reply('The second item is not a rune.');
			return false;
		}

		$modsRune = $rune->getModifiers();
		if (($modsRune === NULL) || (count($modsRune) === 0)) {
			$bot->reply('The rune has no modifiers. Somethings wrong!');
			return false;
		}

		if (!$this->checkCombination($player, $item, $rune))
		{
			$bot->reply('This item can not get this rune applied to it.');
			return false;
		}

		$mods = SR_Item::mergeModifiers($item->getItemModifiersB(), $rune->getItemModifiersB());
		$fail = SR_Rune::calcFailChance($mods)/10;
		$break = SR_Rune::calcBreakChance($mods)/10;
		$price_u = $this->calcUpgradePrice($player, $rune->getItemPriceStatted());
		$dpu = Shadowfunc::displayNuyen($price_u);

		## Confirm
		$pid = $player->getID();
		$msg = implode(' ', $args);
		$old_msg = isset(self::$UPGRADE_CONFIRM[$pid]) ? self::$UPGRADE_CONFIRM[$pid] : '';
		if ($msg !== $old_msg)
		{
			self::$UPGRADE_CONFIRM[$pid] = $msg;
			return $player->message(sprintf(
				'The smith examines your items ... "It would cost you %s to upgrade your %s with %s. The fail chance is %.02f%% and the break chance is %.02f%%. Please retype to confirm.',
			Shadowfunc::displayNuyen($price_u), $item->getItemName(), $rune->getItemName(), $fail, $break
			));
		}
		else {
			unset(self::$UPGRADE_CONFIRM[$pid]);
		}


		//		if ($simulated === true)
		//		{
		//			$price_s = $this->calcSimulationPrice($player, $price_u);
		//			$dps = Shadowfunc::displayNuyen($price_s);
		//			if (false === ($player->pay($price_s))) {
		//				$bot->reply(sprintf('The smith says: "I am sorry chummer, the simulation will cost %s."', $dps));
		//				return false;
		//			}
		//			$bot->reply(sprintf('You pay %s and the smith examines your items: "The upgrade would cost %s. Chance to fail: %s%%. Chance to break: %s%%."', $dps, $dpu, $fail, $break));
		//			return true;
		//		}
		//		else
		{
			if (!$player->hasNuyen($price_u)) {
				$bot->reply(sprintf('The smith says: "I am sorry chummer, the upgrade would cost you %s."', $dpu));
				return false;
			}
				
				
			$player->message('The smith takes your items and goes to work...');
			$player->removeItem($rune);
				
			if (Shadowfunc::dicePercent($fail)) {
				if (Shadowfunc::dicePercent($break)) {
					$player->removeItem($item);
					$bot->reply(sprintf('The upgrade horrible failed and the item and the rune is lost. The smith is very sorry and you don`t need to pay any money.'));
				}
				else {
					$price_f = $this->calcUpgradePrice($player, 0);
					$player->pay($price_f);
					$dpf = Shadowfunc::displayNuyen($price_f);
					$bot->reply(sprintf('The upgrade failed and the rune is lost. You only need to pay %s for the work.', $dpf));
				}
			}
			else {
				$player->pay($price_u);
				$item->addModifiers($rune->getItemModifiersB(), true);
				$item->addModifiers($rune->getItemModifiersA($player), true);
				$bot->reply(sprintf('The upgrade succeeded. You pay %s and the smith presents you a fine %s.', $dpu, $item->getItemName()));
			}
				
			$player->modify();
				
			return true;
		}
}

private function checkCombination(SR_Player $player, SR_Item $item, SR_Rune $rune)
{
	if ($rune->isMixedRune())
	{
		$player->message('The rune has mixed mount and equipment modifiers. You have to split it first.');
		return false;
	}

	$mr = $rune->isMountRune();

	if ($rune->isMountRune())
	{
		if (!($item instanceof SR_Mount))
		{
			$player->message('This rune can only applied to mounts.');
			return false;
		}
	}
	else
	{
		if (!$item->isItemStattable())
		{
			$player->message('This rune can only be applied to equipment.');
			return false;
		}
	}

	return true;
}

#############
### Split ###
#############
public function on_split(SR_Player $player, array $args)
{
	static $confirm = array();

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
		$bot->reply('You don`t have that item.');
		return false;
	}
	$pid = $player->getID();
	$itemname = $rune->getItemName();
	$confirmed = ( (isset($confirm[$pid])) && ($confirm[$pid]===$rune->getID()) );
	unset($confirm[$pid]);

	if (!($rune instanceof SR_Rune))
	{
		$bot->reply('You can only split runes.');
		return false;
	}
	$mods = array_merge($rune->getItemModifiersA($player), $rune->getItemModifiersB());
	if (count($mods) < 2)
	{
		$bot->reply('This rune has only one modifier.');
		return false;
	}

	# Check price
	$price = $this->calcSplitPrice($player, $rune->getItemPriceStatted());
	$dp = Shadowfunc::displayNuyen($price);
	if (!$player->hasNuyen($price))
	{
		$player->message(sprintf('It would cost %s to split the %s, but you only have %s.', $dp, $itemname, $player->getNuyen()));
		return false;
	}

	# Confirm?
	if (!$confirmed)
	{
		$confirm[$pid] = $rune->getID();
		$player->message(sprintf('It would cost %s to split the %s. Retype your command to confirm.', $dp, $itemname));
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
		$bot->reply(sprintf('The rune burned into dust while splitting it. You don\'t need to pay.'));
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

	return $bot->reply(sprintf('You pay %s and split your %s into %s.', $dp, $itemname, GWF_Array::implodeHuman($names)));
}

}
?>