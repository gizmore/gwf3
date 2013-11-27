<?php
final class Shadowcmd_stop extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false === self::checkLeader($player))
		{
			return false;
		}
		$p = $player->getParty();
		
		if ($p->isSleeping())
		{
			$p->popAction(true);
// 			$p->notice(sprintf('You interrupt the parties sleeping and continue %s', $p->displayAction()));
			return true;
		}
		
		if (!$p->isMoving())
		{
			$bot->rply('1170');
// 			$bot->reply('Your party is not moving.');
			return false;
		}
		
		$c = $p->getCity();
		$p->pushAction(SR_Party::ACTION_OUTSIDE, $c);
		$p->ntice('5242');
// 		$p->notice('The party stopped. What now?!');
		return true;
	}
}
?>
