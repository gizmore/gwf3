<?php
abstract class SR_Subway extends SR_Location
{
	# array(array($target, $price, $time, $level))
	public abstract function getSubwayTargets(SR_Player $player);
	
	public function getLeaderCommands(SR_Player $player) { return array('travel'); }
	
	public function calcTicketPrice($price, SR_Player $player)
	{
		$neg = Common::clamp($player->get('negotiation'), 0, 10) * 0.01;
		$mc = $player->getParty()->getMemberCount();
		$price = $price * $mc;
		$price = $price * (1.0 - $neg);
		return $price;
	}
	
	private function getSubwayTarget(SR_Player $player, $arg)
	{
		$targets = $this->getFilteredTargets($player);
		
		if (is_numeric($arg))
		{
			$arg = (int)$arg;
			if ($arg < 1 || $arg > count($targets)) {
				return false;
			}
			$arg--;
			list($target, $price, $time) = $targets[$arg];
			return array($target, $this->calcTicketPrice($price, $player), $time);
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

	private function getFilteredTargets(SR_Player $player)
	{
		$back = array();
		$targets = $this->getSubwayTargets($player);
		$party = $player->getParty();
		foreach ($targets as $data)
		{
			list($target, $price, $time, $level) = $data;
			if ($level <= $party->getMin('level'))
			{
				$back[] = $data;
			}
		}
		return $back;
	}
	
	private function showSubwayTargets(SR_Player $player)
	{
		$bot = Shadowrap::instance($player);
		$out = '';
		
		foreach ($this->getFilteredTargets($player) as $i => $data)
		{
			list($target, $price, $time, $level) = $data;
			$out .= sprintf(', %s:%s(%s)', $i+1, $target, $price);
		}
		
		if ($out === '') {
			$out = 'There are no trains planned for today.';
		}
		else {
			$out = substr($out, 2);
		}
		
		$bot->reply($out);
	}
	
	public function on_travel(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$c = Shadowrun4::SR_SHORTCUT;
		
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
		$dp = Shadowfunc::displayNuyen($price);
		if (false === ($player->pay($price))) {
			$bot->reply(sprintf('You can not afford %d tickets for %s', $party->getMemberCount(), $dp));
			return false;
		}
		
		$eta = GWF_Time::humanDuration($time);
		$party->message($player, " paid the price of $dp and you take the next train to $target. ETA: $eta");
		$party->pushAction(SR_Party::ACTION_TRAVEL, $target, $time);
		
		return true;
	}
}
?>