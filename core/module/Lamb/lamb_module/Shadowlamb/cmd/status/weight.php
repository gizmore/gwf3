<?php
final class Shadowcmd_weight extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$we = $member->get('weight');
			$mw = $member->get('max_weight');
			$b = $we > $mw ? chr(2) : '';
			$total += $we;
			$back .= sprintf(', %s(%s/%s)', $b.$member->getName().$b, $b.Shadowfunc::displayWeight($we).$b, Shadowfunc::displayWeight($mw));
		}
		$bot->reply(sprintf('Your party carries %s: %s.', Shadowfunc::displayWeight($total), substr($back, 2)));
		return true;
	}
}
?>
