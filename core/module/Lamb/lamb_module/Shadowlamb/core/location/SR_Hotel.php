<?php
abstract class SR_Hotel extends SR_Location
{
	public function isHijackable() { return true; }
	public function getSleepPrice(SR_Player $player) { return 0; }
	public function getNPCS(SR_Player $player) { return array(); }
	public function getLeaderCommands(SR_Player $player) { return array('sleep'); }
	public function calcPrice(SR_Player $player)
	{
		$p = $this->getSleepPrice($player);
		$n = $player->getParty()->getMemberCount();
		return Shadowfunc::calcBuyPrice($n*$p, $player);
	}
	
	public function getHelpText(SR_Player $player)
	{
		$price = $this->calcPrice($player);
		$c = Shadowrun4::SR_SHORTCUT;
		return sprintf('You can pay %s to %ssleep here and restore your party`s HP/MP.', $price, $c); 
	}
	
	public function on_sleep(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$price = $this->calcPrice($player);
		
		if (!$party->needsToRest()) {
			return $bot->reply('You don`t need to rest.');
		}
		
		
		if (false === ($player->pay($price))) {
			return $bot->reply(sprintf('To rent a room for your party, you need %s nuyen. You only got %s!', $price, $player->getNuyen()));
		}
		
		if ($price > 0) {
			$player->message(sprintf('You pay %s nuyen.', $price));
		}

		$b = chr(2);
		$party->pushAction(SR_Party::ACTION_SLEEP);
		$party->notice("The party goes to sleep. You go to your {$b}own{$b} bedroom.");
	}
}
?>