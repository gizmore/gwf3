<?php
final class Shadowcmd_set_distance extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) === 0)
		{
			return self::showDistances($player);
		}
		
		# err args
		if ( (count($args) !== 1) || (!is_numeric($args[0])) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		
		# Out of bounds
		$d = round(floatval($args[0]), 1);
		if ($d < 1 || $d > SR_Player::MAX_SD)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		
		foreach ($player->getParty()->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->getLangISO() === 'bot')
			{
				$member->msg('5278', array($player->getName(), $d));
			}
		}
		
		$player->updateField('distance', $d);
		return $player->msg('5122', array($d));
// 		$player->message(sprintf("Your default combat distance has been set to %.01f meters.", $d));
// 		return true;
	}
	
	private static function showDistances(SR_Player $player)
	{
		$p = $player->getParty();
		$format = $player->lang('fmt_sumlist');
		$key = $player->isFighting() ? '5123' : '5124';
		$out = '';
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$val = $player->isFighting() ? $p->getDistance($member) : $member->getBase('distance');
			$out .= sprintf($format, $member->getEnum(), $member->getName(), $val);
// 			$out .= sprintf(', %s:%s(%s)', $member->getName(), $member->getBase('distance'), $p->getDistance($member));
		}
		return $player->msg($key, array(ltrim($out, ',; ')));
	}
	
}
?>
