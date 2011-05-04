<?php
abstract class SR_Bank extends SR_Location
{
	public function getTransactionPrice() { return 0; }
	
	public function getCommands(SR_Player $player) { return array('pushi', 'popi', 'pushy', 'popy'); }

	public function getHelpText(SR_Player $player)
	{
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$p = Shadowfunc::displayPrice($this->calcPrice($player));
		return "In a bank you can use {$c}pushi and {$c}popi to bank items, and {$c}pushy and {$c} popy to bank nuyens. Every transaction is $p for you.";
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
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'puhsi'));
			return false;
		}
		
		if (false !== ($error = $this->checkAfford($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}

		if ($item->isEquipped($player)) {
			$player->unequip($item);
		}
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('put your %s into your bank account.', $item->getItemName());
		
		
		$player->removeFromInventory($item);
		$player->putInBank($item);
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
	
	public function on_popi(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);

		if (count($args) !== 1)
		{
			$this->showBank($player);
			return true;
		}
		
		if (false !== ($error = $this->checkAfford($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (false === ($item = $player->removeFromBank($args[0]))) {
			$bot->reply('You don`t have that item in your bank.');
			return false;
		}
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('remove %s from your bank account and put it in your inventory.', $item->getItemName());
		$bot->reply($paymsg);
		return true;
	}
	
	#############
	### Nuyen ###
	#############
	private function showNuyen(SR_Player $player)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(sprintf('You carry %s. In your bank are %s. Every transaction costs %s', $player->displayNuyen(), Shadowfunc::displayPrice($player->getBase('bank_nuyen')), Shadowfunc::displayPrice($this->calcPrice($player))));
	}
	
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
			$bot->reply(sprintf('You can not push %s, because you only carry %s.', Shadowfunc::displayPrice($want), $player->displayNuyen()));
			return false;
		}
		
		$player->alterField('bank_nuyen', $want);
		$player->giveNuyen(-$want);
		$have = $player->getBase('bank_nuyen');
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('push %s into your bank account(now %s) and keep %s in your inventory.', Shadowfunc::displayPrice($want), Shadowfunc::displayPrice($have), $player->displayNuyen());
		$bot->reply($paymsg);
		return true;
		
	}

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
			$bot->reply(sprintf('You can not pop %s, because you only have %s in your bank account.', Shadowfunc::displayPrice($want), Shadowfunc::displayPrice($have)));
			return false;
		}
		
		$player->alterField('bank_nuyen', -$want);
		$player->giveNuyen($want);
		$have = $player->getBase('bank_nuyen');
		
		if ('' === ($paymsg = $this->pay($player))) {
			$paymsg .= 'You ';
		}
		$paymsg .= sprintf('pop %s from your bank account(%s left) and now carry %s.', Shadowfunc::displayPrice($want), Shadowfunc::displayPrice($have), $player->displayNuyen());
		$bot->reply($paymsg);
		return true;
	}
}
?>