<?php
/**
 * Show XP stats for your party.
 * @author gizmore
 */
final class Shadowcmd_xp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		
		$back = '';
		$format = $player->lang('fmt_xp'); # 1-gizmore L14(177/288xp) KA(5.4/12xp)
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$back .= sprintf($format,
				$member->getEnum(), $member->getName(), $member->getBase('level'),
				round($member->getBase('xp_level'), 2), $member->getXPPerLevel(),
				round($member->getBase('xp'), 2), $member->getXPPerKarma()
			);
		}
		
		return self::rply($player, '5308', array(ltrim($back, '|,; ')));
	}
}
?>
