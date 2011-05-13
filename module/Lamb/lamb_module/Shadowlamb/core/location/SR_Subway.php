<?php
abstract class SR_Subway extends SR_Location
{
	# array(array($target, $price, $time))
	public abstract function getSubwayTargets();
	
	public function getLeaderCommands(SR_Player $player) { return array('travel'); }
	
	private function getSubwayTarget(SR_Player $player, $arg)
	{
		$targets = $this->getSubwayTargets();
		
		if (is_numeric($arg))
		{
			$arg = (int)$arg;
			if ($arg < 1 || $arg > count($targets)) {
				return false;
			}
			list($target, $price, $time) = $targets[$arg];
			return array($target[$arg], $this->calcTicketPrice($price, $player), $time);
		}
		
		$arg = strtolower($arg);
		foreach ($targets as $target)
		{
			list($target, $price, $time) = $target;
			
			if (strtolower($target) === $arg)
			{
				return array($target, $this->calcTicketPrice($price, $player), $time);
			}
		}
		return false;
	}
	
	private function showSubwayTargets(SR_Player $player)
	{
		
	}
	
	public function on_travel(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		
		if (count($args) === 0)
		{
			$this->showSubwayTargets($player);
			return true;
		}
		
		if (false === ($target = $this->getSubwayTarget($player, $args[0]))) {
			$bot->reply("This target is unknown. Check available targets with {$c}travel.");
			return false;
		}
		
		list($target, $price, $time) = $target;
		$dp = Shadowfunc::displayPrice($price);
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('You can not afford %d tickets for %s', $party->getMemberCount(), $dp));
			return false;
		}
		
		$party->message($player, " paid the price of $dp and you take the next train to $target.");
		$party->pushAction(SR_Party::ACTION_TRAVEL, $target, $time);
		
		return true;
	}
}
?>