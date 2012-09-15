<?php
class Shadowcmd_asl extends Shadowcmd
{
	public static function onASLHelp(SR_Player $player) { return Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'asl')); }
	
	public static function execute(SR_Player $player, array $args)
	{
		$c = count($args);
		if ($c > 1)
		{
			return self::onASLHelp($player);
		}
		return self::onASLShow($player, $args);
	}
	
	public static function onASLShow(SR_Player $player, array $args)
	{
		switch (count($args))
		{
			case 0: return self::onASLShowPlayer($player, $args);
			case 1: return self::onASLShowParty($player, $args);
			default: return self::onASLHelp($player);
		}
	}
	
	public static function onASLShowPlayer(SR_Player $player, array $args)
	{
		$b = chr(2);
		if ($player->getBase('age') > 0)
		{
			return self::rply($player, '5012', array(Shadowfunc::displayASL($player), self::translate('asl')));
// 			return self::reply($player, sprintf("Your asl: %s. Use #asl [<age|bmi|height>] for party sums.", Shadowfunc::displayASL($player)));
		}
		else
		{
			$player->msg('1011', array(self::translate('aslset')));
// 			$player->message(sprintf("You did not setup your asl with {$b}#aslset{$b} yet. You need to do this to start moving in the game."));
			return false;
		}
	}
	
	public static function onASLShowParty(SR_Player $player, array $args)
	{
		$type = strtolower(array_shift($args));
		switch ($type)
		{
			case 'a': case 'age': return self::onASLShowPartyB($player, 'age');
			case 'b': case 'bmi': return self::onASLShowPartyB($player, 'bmi');
			case 'h': case 'hgt': case 'height': return self::onASLShowPartyB($player, 'height');
			default: return self::onASLShowPlayer($player, $args);
		}
	}
	
	public static function onASLShowPartyB(SR_Player $player, $field)
	{
		$out = '';
		$sum = 0;
		$format = Shadowrun4::lang('fmt_sumlist');
		foreach ($player->getParty()->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$val = Common::clamp(intval($member->getBase($field)), 0);
			$sum += $val;
			switch ($field)
			{
				case 'age': $out2 = "{$val}y"; break;
				case 'bmi': $out2 = Shadowfunc::displayWeight($val); break;
				case 'height': $out2 = Shadowfunc::displayDistance($val, 2); break;
				default: self::reply($player, 'Error unknown field in onASLShowPartyB()'); return false;
			}
			$out .= sprintf($format, $member->getEnum(), $member->getName(), $out2);
		}
		switch ($field)
		{
			case 'age': $sumtxt = "{$sum}y"; break;
			case 'bmi': $sumtxt = Shadowfunc::displayWeight($sum); break;
			case 'height': $sumtxt = Shadowfunc::displayDistance($sum, 2); break;
			default: self::reply($player, 'Error unknown field2 in onASLShowPartyB()'); return false;
		}
		self::rply($player, '', array(Shadowrun4::lang('sum_'.$field), $sumtxt, ltrim($out, ',; ')));
		return true;
	}
}
?>