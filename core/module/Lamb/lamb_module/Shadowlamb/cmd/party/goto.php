<?php
final class Shadowcmd_goto extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (false !== ($error = self::checkLeader($player)))
		{
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'goto'));
			return false;
		}
		
		$party = $player->getParty();
		$cityname = $party->getCity();
		$cityclass = $party->getCityClass();
		
		if (false !== ($error = self::checkMove($party)))
		{
			$bot->reply($error);
			return false;
		}
		
		$tlc = $args[0];
		
		if (is_numeric($tlc))
		{
			$tlc = $player->getKnowledgeByID('places', $tlc);
		}
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $cityname));
			return false;
		}
		
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc))
		{
			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($party->getLocation('inside') === $tlc)
		{
			$bot->reply(sprintf('You are already in %s.', $tlc));
			return false;
		}
		
		if ($party->getLocation('outside') === $tlc)
		{
			$target->onEnter($player);
			return true;
		}
		
		if ( ($party->getAction() === SR_Party::ACTION_GOTO) && ($party->getTarget() === $tlc) )
		{
			$bot->reply(sprintf('You are already going to %s.', $tlc));
			return false;
		}

		$cityclass = $party->getCityClass();
		$eta = $cityclass->getGotoETA($party);
		
		$party->pushAction(SR_Party::ACTION_GOTO, $tlc, $eta);
		$party->setContactEta(rand(5,15));
		$party->notice(sprintf('You are going to %s. ETA: %s.', $tlc, GWF_Time::humanDuration($eta)));
		
		return true;
	}
}
?>
