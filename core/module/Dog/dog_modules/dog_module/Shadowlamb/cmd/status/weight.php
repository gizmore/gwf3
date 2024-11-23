<?php
final class Shadowcmd_weight extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
// 		$party = $player->getParty();
// 		$members = $party->getMembers();
		$total = 0;
		$back = '';
		$format = $player->lang('fmt_sumlist');
		foreach ($player->getParty()->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$we = $member->get('weight');
			$mw = $member->get('max_weight');
			$b = $we > $mw ? chr(2) : '';
			$total += $we;
			$summand = sprintf('%s/%s', $b.Shadowfunc::displayWeight($we).$b, Shadowfunc::displayWeight($mw));
			$back .= sprintf($format, $member->getEnum(), $b.$member->getName().$b, $summand);
// 			$back .= sprintf(', %s(%s/%s)', $b.$member->getName().$b, $b.Shadowfunc::displayWeight($we).$b, Shadowfunc::displayWeight($mw));
		}
		return $player->msg('5064', array(Shadowfunc::displayWeight($total), ltrim($back, ',; ')));
// 		$bot->reply(sprintf('Your party carries %s: %s.', Shadowfunc::displayWeight($total), substr($back, 2)));
// 		return true;
	}
}
