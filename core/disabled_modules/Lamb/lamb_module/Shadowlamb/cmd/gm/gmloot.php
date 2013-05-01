<?php
final class Shadowcmd_gmloot extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) !== 2) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gmloot'));
			return false;
		}

		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if ($target === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		
		if (Common::isNumeric($args[1]))
		{
			$target->giveItems(Shadowfunc::randLoot($target, $args[1]), 'gmloot');
		}
		else
		{
			
		}
		
		return true;
	}
}
?>
