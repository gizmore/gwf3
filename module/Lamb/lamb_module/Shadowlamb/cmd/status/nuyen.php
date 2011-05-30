<?php
final class Shadowcmd_nuyen extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$b = chr(2);
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
		$i = 1;
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$ny = $member->getBase('nuyen');
			$total += $ny;
			$back .= sprintf(', %s-%s(%s)', $b.($i++).$b, $member->getName(), Shadowfunc::displayPrice($ny));
		}
		$bot->reply(sprintf('Your party has %s: %s.', Shadowfunc::displayPrice($total), substr($back, 2)));
		return true;
	}
}
?>
