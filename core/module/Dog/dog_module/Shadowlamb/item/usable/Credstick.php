<?php
class Item_Credstick extends SR_Usable
{
	public function getItemDescription() { return sprintf("You can access your bank money with a Credstick. Try #use Credstick [<push|pop>] [<amount>]. Each transaction cost %s with your stick. Example #use Credstick push 100.", Shadowfunc::displayNuyen($this->getTransactionCost())); }
	public function getItemPrice() { return 129.95; }
	public function getItemUsetime() { return 20; } 
	public function getItemWeight() { return 150; }
	public function isItemFriendly() { return false; }
	public function isItemOffensive() { return false; }
	
	public function getTransactionCost() { return 50; }
//	public function getTransactionPopPercent() { return 0; }
//	public function getTransactionPushPercent() { return 5; }
	
	protected function reply(SR_Player $player, $message)
	{
		if ($player->isFighting()) {
			$player->message($message);
		} else {
			Shadowrap::instance($player)->reply($message);
		}
		return true;
	}
	
	public function onItemUse(SR_Player $player, array $args)
	{
//		$cost = $this->getTransactionCost();
		
		# Show balance
		if (count($args) !== 2)
		{
			return $this->onItemUsePop($player, 0);
		}
		
		# Book money
		$p = $player->getParty();
		if ( (!$p->isInsideLocation()) || (!$p->getLocationClass()->hasATM()) )
		{
			$this->reply($player, "You are not inside a location with an ATM. Towers and dungeons usually don't have those.");
			return false;
		}
		
		if (0 === ($amount = (int)$args[1])) {
			$this->reply($player, "Please push or pop a positive amount of Nuyen.");
			return false;
		}
		
		switch (strtolower($args[0]))
		{
			case 'push': return $this->onItemUsePush($player, $amount);
			case 'pop': return $this->onItemUsePop($player, $amount);
			default: $player->message('Try #u Credstick push <amt>. Try #u Credstick pop <amt>.'); return false;
		}
	}
	
	public function onItemUsePop(SR_Player $player, $amount)
	{
		$b = chr(2);
		$have = $player->getNuyen();
		$bank = $player->getBankNuyen();
		if ($amount <= 0)
		{
			$message = sprintf("Your bank account is {$b}%s Nuyen{$b}. You carry %s Nuyen. In total you have %s Nuyen.", $player->displayBankNuyen(), $player->displayNuyen(), Shadowfunc::displayNuyen($bank+$have));
			return $this->reply($player, $message);
		}
		
		$cost = $this->getTransactionCost();
		$need = $amount + $cost;
		
		if ($bank < $need)
		{
			$this->reply($player, sprintf("You want to pop %s(+%s)=%s Nuyen from your bank account, but you only have %s.", $amount, $cost, $need, $bank));
			return false;
		}
			
		$player->giveNuyen($amount);
		$player->increase('sr4pl_bank_nuyen', -$need);
		$this->reply($player, sprintf("You booked %s(+%s)=%s Nuyen from your bank account (%s left). You now carry %s.", $amount, $cost, $need, $player->getBankNuyen(), $player->displayNuyen()));
	}
	
	public function onItemUsePush(SR_Player $player, $amount)
	{
		$have = $player->getNuyen();
		$cost = $this->getTransactionCost();
		
		if ($amount <= $cost) {
			$this->reply($player, "You want to send {$amount} Nuyen to your Bank account, but that's below the cost per transaction of {$cost}.");
			return false;
		}

		if ($have < $amount)
		{
			$this->reply($player, sprintf("You want to send %s Nuyen to your bank account, but you only have %s.", $amount, $have));
			return false;
		}
		
		$player->giveNuyen(-$amount);
		$player->increase('sr4pl_bank_nuyen', $amount-$cost);
		$this->reply($player, sprintf("You send %s(+%s)=%s Nuyen to your bank account (%s now). You now carry %s.", $amount-$cost, $cost, $amount, $player->getBankNuyen(), $player->displayNuyen()));
		return true;
	}
	
}
?>