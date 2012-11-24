<?php
final class Shadowcmd_karma extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$format = $player->lang('fmt_sumlist');
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$karma = $member->getBase('karma');
			$total += $karma;
			$back .= sprintf($format, $member->getEnum(), $member->getName(), $karma);
// 			$back .= sprintf(', %s-%s(%s)', $b.($member->getEnum()).$b, $member->getName(), $karma);
		}
		return self::rply($player, '5052', array($total, ltrim($back, ',; ')));
// 		$bot->reply(sprintf('Your party has %s karma: %s.', $total, substr($back, 2)));
// 		return true;
	}
}
?>
