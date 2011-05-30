<?php
final class Shadowcmd_exit extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		if (false !== ($error = self::checkMove($party))) {
			$bot->reply($error);
			return false;
		}
		$a = SR_Party::ACTION_OUTSIDE;
		$party->pushAction($a);
		$bot->reply(sprintf('You exit the %s.', $party->getLocation($a)));
		return true;
	}
}
?>
