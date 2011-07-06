<?php
final class Shadowcmd_fight extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$a = $p->getAction();
		if ($p->isTalking())
		{
			$ep = $p->getEnemyParty();
			
			if ($ep === false)
			{
				$player->message('Error: Cannot get enemy party for your party. Tell gizmore!');
				return true;
			}
			
			if (SR_KillProtect::isKillProtectedPartyLevel($p, $ep))
			{
				return true;
			}
			
			if (false !== ($time = SR_KillProtect::isKillProtectedParty($p, $ep)))
			{
				$wait = GWF_Time::humanDuration($time-Shadowrun4::getTime());
				$player->message(sprintf('You cannot attack this party again. Please wait %s.', $wait));
				return true;
			}
			
			$p->popAction();
			if ($ep !== false)
			{
				$ep->popAction();
			}
			$p->fight($ep, true);
			return true;
		}
		elseif ($a === SR_Party::ACTION_INSIDE)
		{
			$bot = Shadowrap::instance($player);
			if (count($args) !== 1) {
				$bot->reply(Shadowhelp::getHelp($player, 'fight'));
				return false;
			}
			if (false === ($target = Shadowfunc::getPlayerInLocation($player, $args[0]))) {
				$bot->reply(sprintf('%s is not here.', $args[0]));
				return false;
			}
			
			$ep = $target->getParty();
			$p->fight($ep, true);
			return true;
		}
		return false;
	}
}
?>
