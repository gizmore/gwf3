<?php
abstract class SR_Blacksmith extends SR_Store
{
	public abstract function getSimulationPrice();
	public abstract function getUpgradePrice();
	public abstract function getUpgradePercentPrice();
	
	public function getCommands(SR_Player $player) { return array('view','buy','sell','break','simulate','upgrade'); }
	public function getEnterText(SR_Player $player) { return 'You enter the '.$this->getName().'. You see two dwarfs at the counter.'; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "At a blacksmith you can {$c}upgrade equipment with runes. Do {$c}simulate first if you like to see the odds. You can also {$c}break items into runes. Also {$c}buy,{$c}sell and {$c}view works here."; }

	public function calcUpgradePrice(SR_Player $player, $price)
	{
		return Shadowfunc::calcBuyPrice(($price*$this->getUpgradePercentPrice()/100)+$this->getUpgradePrice(), $player);
	}
	
	public function calcSimulationPrice(SR_Player $player, $price)
	{
		return Shadowfunc::calcBuyPrice($this->getSimulationPrice(), $player);
	}
	
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
		$itemname = $item->getItemName();
		
		$price = Shadowfunc::calcBuyPrice($item->getItemPriceStatted()*0.15, $player);
		$p = Shadowfunc::displayPrice($price);
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('The employee shakes his head: "Nono, it will cost %s to break this item. You only have %s."', $p, $player->displayNuyen()));
			return false;
		}
		$modifiers = $item->getItemModifiersB();
//		$item->saveVar('sr4it_modifiers', NULL);
//		$item->initModifiersB();
		
		if ($item->isEquipped($player)) {
			$player->unequip($item);
		}
		$item->deleteItem($player);
		
		$runestr = '';
		$runes = array();
		foreach ($modifiers as $k => $v)
		{
			$v -= 0.2;
			if ($v <= 0) { continue; }
			$rn = sprintf('Rune_of_%s:%s', $k, $v);
			if (false === ($rune = SR_Item::createByName($rn))) {
				continue;
			}
			$runes[] = $rune;
			$runestr .= ', '.$rn;
		}
		$player->giveItems($runes);
		$bot->reply(sprintf('You pay %s and break the %s into %s.', $p, $itemname, substr($runestr, 2)));
		$player->modify();
		return true;
	}

	public function on_upgrade(SR_Player $player, array $args) { return $this->onUpgrade($player, $args, false); }
	public function on_simulate(SR_Player $player, array $args) { return $this->onUpgrade($player, $args, true); }
	private function onUpgrade(SR_Player $player, array $args, $simulated=true)
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

		$mods = SR_Item::mergeModifiers($item->getItemModifiersB(), $rune->getItemModifiersB());
		$fail = SR_Rune::calcFailChance($mods)/10;
		$break = SR_Rune::calcBreakChance($mods)/10;
		$price_u = $this->calcUpgradePrice($player, SR_Rune::calcPrice($mods));
		$dpu = Shadowfunc::displayPrice($price_u);
		
		if ($simulated === true)
		{
			$price_s = $this->calcSimulationPrice($player, $price_u);
			$dps = Shadowfunc::displayPrice($price_s);
			if (false === ($player->pay($price_s))) {
				$bot->reply(sprintf('The smith says: "I am sorry chummer, the simulation will cost %s."', $dps));
				return false;
			}
			$bot->reply(sprintf('You pay %s and the smith examines your items: "The upgrade would cost %s. Chance to fail: %s%%. Chance to break: %s%%."', $dps, $dpu, $fail, $break));
			return true;
		}
		else
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
					$price_f = calcUpgradePrice($player, 0);
					$player->pay($price_f);
					$dpf = Shadowfunc::displayPrice($price_f);
					$bot->reply(sprintf('The upgrade failed and the rune is lost. You only need to pay %s for the work.', $dpf));
				}
			}
			else {
				$player->pay($price_u);
				$item->addModifiers($rune->getItemModifiersB(), true);
				$bot->reply(sprintf('The upgrade succeeded. You pay %s and the smith presents you a fine %s.', $dpu, $item->getItemName()));
			}
			return true;
		}
	}
	
}
?>