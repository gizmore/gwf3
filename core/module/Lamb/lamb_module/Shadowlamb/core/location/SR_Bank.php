<?php
abstract class SR_Bank extends SR_Location
{
	public function getAreaSize() { return 48; }
	
	public function getTransactionPrice() { return 0; }
	
	public function getCommands(SR_Player $player) { return array('pushi', 'popi', 'pushy', 'popy'); }

	public function getHelpText(SR_Player $player)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		$p = Shadowfunc::displayNuyen($this->calcPrice($player));
		return "In a bank you can use {$c}pushi and {$c}popi to bank items, and {$c}pushy and {$c}popy to store nuyen. Every transaction is $p for you.";
	}
	
	public function calcPrice(SR_Player $player)
	{
		if (0 >= ($base = $this->getTransactionPrice())) {
			return 0;
		}
		return Shadowfunc::calcBuyPrice($base, $player);
	}
	
	public function checkAfford(SR_Player $player)
	{
		if (0 >= ($price = $this->calcPrice($player))) {
			return false;
		}
		$nuyen = $player->getNuyen();
		if ($nuyen < $price) {
			return sprintf('You can not afford to use the bank. This cost %s nuyen and you only have %s.', $price, $nuyen);
		}
		return false;
	}
	
	private function pay(SR_Player $player)
	{
		if (0 >= ($price = $this->calcPrice($player))) {
			return '';
		}
		$player->pay($price);
		return sprintf('You pay %s nuyen and ', $price);
	}
	
	#############
	### Items ###
	#############
	public function on_pushi(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if ( (count($args) === 0) || (count($args) > 2) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'pushi'));
			return false;
		}
		
		$args[0] = strtolower($args[0]);
		
		if (false !== ($error = $this->checkAfford($player)))
		{
			$bot->reply($error);
			return false;
		}
		if (false === ($item = $player->getItem($args[0])))
		{
			$bot->reply('You don`t have that item.');
			return false;
		}
		
		# Equipped?
		if ($item->isEquipped($player))
		{
			$player->unequip($item);
			$player->removeFromInventory($item);
			$player->putInBank($item);
			$stored = 1;
		}
		
		# A stackable?
		elseif ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			
			# Store all amt
			if (count($args) === 1)
			{
				$player->removeFromInventory($item);
				$player->putInBank($item);
				$stored = $have_amt;
			}
			
			# Split item
			else
			{
				$amt = (int) $args[1];
				if ($amt > $have_amt)
				{
					$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
					return false;
				}
				
				$item->useAmount($player, $amt);
				$item2 = SR_Item::createByName($item->getItemName(), $amt, true);
				$item2->saveVar('sr4it_uid', $player->getID());
				$player->putInBank($item2);
				$stored = $amt;
			}
		}
		
		# Not stackable
		else
		{
			if (count($args) === 1)
			{
				$player->removeFromInventory($item);
				$player->putInBank($item);
				$stored = 1;
			}
			
			else
			{
				$amt = (int)$args[1];
				if ($amt <= 0)
				{
					$bot->reply('Please push a larger amount than zero.');
					return false;
				}
				
				$items2 = $player->getInvItems($item->getItemName(), $amt);
				if (count($items2) < $amt)
				{
					$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
					return false;
				}
				
				$stored = 0;
				foreach ($items2 as $item2)
				{
					if ($player->removeFromInventory($item2))
					{
						if ($player->putInBank($item2))
						{
							$stored++;
						}
					}
				}
			}
		}
		
		# Pay
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('put %d of your %s into your bank account.', $stored, $item->getItemName());
		# Out
		$player->modify();
		$bot->reply($paymsg);
		
		return true;
	}
	
	private function showBank(SR_Player $player)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(sprintf('Your bank: %s.', Shadowfunc::getBank($player)));
		return true;
	}
	
	/**
	 * Pop items from your bank.
	 * @param SR_Player $player
	 * @param array $args
	 * @return boolean
	 */
	public function on_popi(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);

		# BankInv
		if (count($args) === 0)
		{
			$this->showBank($player);
			return true;
		}
		
		# Errors
		if (count($args) > 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'popi'));
			return false;
		}
		if (false !== ($error = $this->checkAfford($player)))
		{
			$bot->reply($error);
			return false;
		}
		if (false === ($item = $player->getBankItem($args[0])))
		{
			$bot->reply('You don`t have that item in your bank.');
			return false;
		}
		
		$itemname = $args[0];
		
		# Whole stack or single
		if (count($args) === 1)
		{
			if (!$player->removeFromBank($item))
			{
				$bot->reply('You don`t have that item in your bank.');
				return false;
			}
			if (!$player->giveItems(array($item)))
			{
				$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
				return false;
			}

			$collected = $item->getAmount();
		}
		
		else
		{
			# Args
			$amt = (int)$args[1];
			if ($amt <= 0)
			{
				$bot->reply('Please pop a positve amount of items.');
				return false;
			}
			
			# Limits
			if ($item->isItemStackable())
			{
				$have_amt = $item->getAmount();
			}
			else
			{
				$items2 = $player->getBankItemsByItemName($item->getItemName());
				$have_amt = count($items2);
			}
			if ($amt > $have_amt)
			{
				$bot->reply(sprintf('You do not have that much %s in your bank.', $item->getItemName()));
				return false;
			}
			
			# Split Stack
			if ($item->isItemStackable())
			{
				if (false === $item->useAmount($player, $amt))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				if (false === $item2 = SR_Item::createByName($item->getItemName(), $amt, true))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}

				if (false === $player->giveItem($item2))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				$collected = $amt;
			}
			
			# Multi Equipment
			else
			{
				$collected = 0;
				foreach ($items2 as $item2)
				{
					if (false === $player->removeFromBank($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					elseif (false === $player->giveItem($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					else
					{
						$collected++;
						if ($collected >= $amt)
						{
							break;
						}
					}
				}
			}
		}
		
		$player->updateInventory();
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('remove %d %s from your bank account and put it into your inventory.', $collected, $item->getItemName());
		$bot->reply($paymsg);
		return true;
	}
	
	##################
	### Show Nuyen ###
	##################
	private function showNuyen(SR_Player $player)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(sprintf('You carry %s. In your bank are %s. Every transaction costs %s', $player->displayNuyen(), Shadowfunc::displayNuyen($player->getBase('bank_nuyen')), Shadowfunc::displayNuyen($this->calcPrice($player))));
	}
	
	##################
	### Push Nuyen ###
	##################
	public function on_pushy(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$this->showNuyen($player);
			return true;
		}
		if (false !== ($error = $this->checkAfford($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (0 >= ($want = round(floatval($args[0]), 2))) {
			$bot->reply(sprintf('Please push a positive amount of nuyen.'));
			return false;
		}
		
		$have = $player->getNuyen();
		if ($want > $have) {
			$bot->reply(sprintf('You can not push %s, because you only carry %s.', Shadowfunc::displayNuyen($want), $player->displayNuyen()));
			return false;
		}
		
		$player->alterField('bank_nuyen', $want);
		$player->giveNuyen(-$want);
		$have = $player->getBase('bank_nuyen');
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('push %s into your bank account(now %s) and keep %s in your inventory.', Shadowfunc::displayNuyen($want), Shadowfunc::displayNuyen($have), $player->displayNuyen());
		$bot->reply($paymsg);
		return true;
		
	}

	#################
	### Pop Nuyen ###
	#################
	public function on_popy(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$this->showNuyen($player);
			return true;
		}
		if (false !== ($error = $this->checkAfford($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (0 >= ($want = round(floatval($args[0]), 2))) {
			$bot->reply(sprintf('Please pop a positive amount of nuyen.'));
			return false;
		}
		
		$have = $player->getBase('bank_nuyen');
		if ($want > $have) {
			$bot->reply(sprintf('You can not pop %s, because you only have %s in your bank account.', Shadowfunc::displayNuyen($want), Shadowfunc::displayNuyen($have)));
			return false;
		}
		
		$player->alterField('bank_nuyen', -$want);
		$player->giveNuyen($want);
		$have = $player->getBase('bank_nuyen');
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('pop %s from your bank account(%s left) and now carry %s.', Shadowfunc::displayNuyen($want), Shadowfunc::displayNuyen($have), $player->displayNuyen());
		$bot->reply($paymsg);
		return true;
	}
}
?>