<?php
final class Shadowcmd_level extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		$p = $player->getParty();
		$out = '';
		$format = $player->lang('fmt_sumlist');
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$summand = sprintf('L%s(%s)', $member->getBase('level'), $member->get('level'));
			$out .= sprintf($format, $member->getEnum(), $member->getName(), $summand);
// 			$out .= sprintf(', %s(L%s(%s))', $member->getName(), $member->getBase('level'), $member->get('level'));
		}
		return $player->msg('5056', array($p->getPartyLevel(), $p->getPartyXP(), SR_Party::XP_PER_LEVEL, ltrim($out, ',; ')));
// 		$bot->reply(sprintf('Your party has level %s(%s/%s): %s.', $p->getPartyLevel(), $p->getPartyXP(), SR_Party::XP_PER_LEVEL, substr($out, 2)));
// 		return true;
	}
}
?>