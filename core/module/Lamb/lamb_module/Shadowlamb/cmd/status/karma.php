<?php
final class Shadowcmd_karma extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$b = chr(2);
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
//		$i = 1;
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$karma = $member->getBase('karma');
			$total += $karma;
			$back .= sprintf(', %s-%s(%s)', $b.($member->getEnum()).$b, $member->getName(), $karma);
		}
		$bot->reply(sprintf('Your party has %s karma: %s.', $total, substr($back, 2)));
		return true;
	}
}
?>
