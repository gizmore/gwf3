<?php
abstract class SR_Hospital extends SR_Store
{
	public abstract function getHealPrice();
	public function calcHealPrice(SR_Player $player) { return Shadowfunc::calcBuyPrice($this->getHealPrice(), $player); }
	
	public function getCommands(SR_Player $player) { return array('heal','view','implant','unplant'); }
	
	public function on_heal(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$price = $this->calcHealPrice($player);
		$p1 = Shadowfunc::displayPrice($price);
		
		if ($player->hasFullHP()) {
			$bot->reply(sprintf('The doctor says: "You don`t need my help, chummer."'));
			return true;
		}
		
		if (!$player->pay($price)) {
			$p2 = Shadowfunc::displayPrice($player->getBase('nuyen'));
			$bot->reply(sprintf('The doctor shakes his head: "No, my friend. Healing you will cost %s but you only have %s."', $p1, $p2));
			return false;
		}
		$player->healHP(100000);
		$bot->reply(sprintf('The doctor takes your %s and heals you.', $p1));
		return true;
	}
	
	public function on_implant(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'implant'));
			return false;
		}
		if (false === ($item = $this->getStoreItem($player, $args[0]))) {
			$bot->reply('We don`t have that item.');
			return false;
		}
		$item instanceof SR_Cyberware;
		
		$price = $item->getStorePrice();
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('You can not afford %s. You need %s but only have %s.', $item->getItemName(), Shadowfunc::displayPrice($price), Shadowfunc::displayPrice($player->getBase('nuyen'))));
			return false;
		}
		
		if ($player->hasCyberware($item->getItemName())) {
			$bot->reply(sprintf('You already have %s implanted.', $item->getItemName()));
			return false;
		}
		
		if (false !== ($error = $item->conflictsWith($player))) {
			$bot->reply(sprintf('You can not implant %s. It conflicts with %s.', $item->getItemName(), $error));
			return false;
		}
		
		if (false !== ($error = $item->checkEssence($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (false === $item->insert()) {
			$bot->reply('Database error 5.');
			return false;
		}
		
		$player->addCyberware($item);
		$bot->reply(sprintf('You paid %s and got %s implanted.', Shadowfunc::displayPrice($price), $item->getItemName()));
		return true;
	}

	public function on_unplant(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'unplant'));
			return false;
		}
		$id = $args[0];
		if (is_numeric($id)) {
			$item = $player->getCyberwareByID($id);
		} else {
			$item = $player->getCyberwareByName($id);
		}
		if ($item === false) {
			$bot->reply('You don`t have this cyberware implanted.');
			return false;
		}
		$item instanceof SR_Cyberware;
		
		$price = Shadowfunc::calcBuyPrice($item->getItemPrice() * 0.10, $player);
		$p1 = Shadowfunc::displayPrice($price);
		if (false === $player->pay($price)) {
			$bot->reply(sprintf('The doctor shakes his head: "My friend, removing this from your body will cost %s, but you only have %s."', $p1, $player->displayNuyen()));
			return false;
		}
		$player->removeCyberware($item);
		$bot->reply(sprintf('You pay %s and got your %s removed.', $p1, $item->getItemName()));
		return true;
	}
}
?>