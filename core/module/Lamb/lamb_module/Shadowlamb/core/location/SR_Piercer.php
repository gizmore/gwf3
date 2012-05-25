<?php
abstract class SR_Piercer extends SR_Location
{
	const CONFIRM_PIERCE = 'KC_PIERCE';
	const CONFIRM_UNPIERCE = 'iamsure';
	
	public function getAbstractClassName() { return __CLASS__; }
	public function displayName(SR_Player $player) { return Shadowrun4::langPlayer($player, 'ln_piercer'); }
	
	public function getCommands(SR_Player $player) { return array('pierce', 'unpierce'); }
	
	public function getPricePierce() { return 1000; }
	public function getPriceUnpierce() { return 500; }
	
	public function getFoundPercentage() { return 40.0; }
	public function getFoundText(SR_Player $player) { return Shadowrun4::langPlayer($player, 'stub_found_piercer'); }
	public function getEnterText(SR_Player $player) { return Shadowrun4::langPlayer($player, 'stub_enter_piercer'); }
	
	public function on_pierce(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'pierce'));
			return false;
		}
		
		if ($player->hasEquipment('piercing'))
		{
			$bot->rply('1183');
			return false;
		}
		
		if (false === ($rune = $player->getInvItem($args[0])))
		{
			$bot->rply('1029');
			return false;
		}
		
		if (!($rune instanceof SR_Rune))
		{
			$bot->rply('1184');
			return false;
		}
		
		if ($rune->isMountRune())
		{
			$bot->rply('1162');
			return false;
		}
		
		$price = Shadowfunc::calcBuyPrice($this->getPricePierce(), $player);
		$dprice = Shadowfunc::displayNuyen($price);
		
		if (!$player->hasNuyen($price))
		{
			$bot->rply('1063', array($dprice, $player->displayNuyen()));
			return false;
		}
		
		$confirm = $player->getTemp(self::CONFIRM_PIERCE, '');
		$itemname = $rune->getItemName();
		if ( ($confirm !== $itemname) && ($itemname !== $args[0]) )
		{
			$player->setTemp(self::CONFIRM_PIERCE, $itemname);
			return $bot->rply('5286', array($dprice, $rune->displayFullName($player)));
		}
		
		if (false === $rune->deleteItem($player))
		{
			$bot->reply('Database error 1');
			return false;
		}
		
		if (false === ($piercing = SR_Item::createByName('Piercing')))
		{
			$bot->reply('Database error 2');
			return false;
		}
		
		if (!$piercing->addModifiers(SR_Item::mergeModifiers($rune->getItemModifiersA($player), $rune->getItemModifiersBArray())))
		{
			$bot->reply('Database error 3');
			return false;
		}
		
		if (false === $player->giveItem($piercing))
		{
			$bot->reply('Database error 6');
			return false;
		}
		
		if (!$player->equip($piercing))
		{
			$bot->reply('Database error 4');
			return false;
		}
		
		if (!$player->giveNuyen(-$price))
		{
			$bot->reply('Database error 5');
			return false;
		}
		
		$player->modify();
		
		return $bot->rply('5287', array($dprice, $rune->displayFullName($player)));
	}

	public function on_unpierce(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) > 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'unpierce'));
			return false;
		}
		
		if (!$player->hasEquipment('piercing'))
		{
			$bot->rply('1182');
			return false;
		}
		
		if (false === ($piercing = $player->getEquipment('piercing')))
		{
			$bot->reply('Database error 3');
			return false;
		}
		
		$price = Shadowfunc::calcBuyPrice($this->getPriceUnpierce(), $player);
		$dprice = Shadowfunc::displayNuyen($price);
		
		if ( (!isset($args[0])) || ($args[0] !== self::CONFIRM_UNPIERCE) )
		{
			return $bot->rply('5288', array($dprice, $piercing->displayFullName($player), self::CONFIRM_UNPIERCE));
		}
		
		
		if (!$player->hasNuyen($price))
		{
			$bot->rply('1063', array($dprice, $player->displayNuyen()));
			return false;
		}
		
		
		if (!$player->updateEquipment('piercing', NULL))
		{
			$bot->reply('Database error 1');
			return false;
		}
		
		if (!$piercing->deleteItem($player))
		{
			$bot->reply('Database error 2');
			return false;
		}
		
		$player->modify();
		
		return $bot->rply('5289', array($dprice, $piercing->displayFullName($player)));
	}
}
?>
