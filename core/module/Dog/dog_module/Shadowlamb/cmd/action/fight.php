<?php
final class Shadowcmd_fight extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$a = $p->getAction();
		if (true === $p->isTalking())
		{
			if (false === ($ep = $p->getEnemyParty()))
			{
				self::reply($player, 'Cannot get enemy party! (tell gizmore)');
				return false;
			}
			
			if (false === self::checkKillProtection($player, $ep))
			{
				return false;
			}
			
			$p->popAction();
			$ep->popAction();
			
			$p->fight($ep, true);
			
			return true;
		}
		
		if ( ($a === SR_Party::ACTION_INSIDE) || ($a === SR_Party::ACTION_OUTSIDE) )
		{
			$bot = Shadowrap::instance($player);
			if (count($args) !== 1)
			{
				$bot->reply(Shadowhelp::getHelp($player, 'fight'));
				return false;
			}
			if (false === ($target = Shadowfunc::getPlayerInLocation($player, $args[0])))
			{
				self::rply($player, '1028', array($args[0]));
// 				$bot->reply(sprintf('%s is not here.', $args[0]));
				return false;
			}
			if (false === ($ep = $target->getParty()))
			{
				self::reply($player, 'Cannot get enemy party! (tell gizmore)');
				return false;
			}
			
			if (false === self::checkKillProtection($player, $ep))
			{
				return false;
			}
			
			$p->fight($ep, true);
			
			return true;
		}
		
		return false;
	}
	
	private static function checkKillProtection(SR_Player $player, SR_Party $ep)
	{
		$p = $player->getParty();
// 		$ep = $p->getEnemyParty();
		
		if ($ep === false)
		{
			$player->message('Error: Cannot get enemy party for your party. Tell gizmore!');
			return false;
		}
		
		if (SR_KillProtect::isKillProtectedPartyLevel($p, $ep, $player, true))
		{
			return false;
		}
		
		if (false !== ($time = SR_KillProtect::isKillProtectedParty($p, $ep)))
		{
			$wait = GWF_Time::humanDuration($time-Shadowrun4::getTime());
			self::rply($player, '1060', array($wait));
// 			$player->message(sprintf('You cannot attack this party again. Please wait %s.', $wait));
			return false;
		}

		SR_BadKarma::onFight($player, $ep);
		
		return true;
	}
}
?>
