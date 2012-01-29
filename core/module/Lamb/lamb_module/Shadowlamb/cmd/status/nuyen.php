<?php
final class Shadowcmd_nuyen extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$members = $party->getMembers();
		$format = Shadowrun4::lang('fmt_sumlist');
		$total = 0;
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$ny = $member->getBase('nuyen');
			$total += $ny;
			$back .= sprintf($format, $member->getEnum(), $member->getName(), Shadowfunc::displayNuyen($ny));
		}
		
		$bot->reply(Shadowrun4::lang('5008', array(Shadowfunc::displayNuyen($total), substr($back, 2))));
// 		$bot->reply(sprintf('Your party has %s: %s.', Shadowfunc::displayNuyen($total), substr($back, 2)));
		return true;
	}
}
?>
