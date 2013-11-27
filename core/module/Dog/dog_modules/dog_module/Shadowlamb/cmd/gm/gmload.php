<?php
final class Shadowcmd_gmload extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gmload'));
			return false;
		}
		
		if (false !== ($target = Shadowrun4::getPlayerByName($args[0])))
		{
			$bot->reply(sprintf('The player %s is already in memory.', $args[0]));
			return false;
		}
		
		if (false === ($target = Shadowrun4::loadPlayerByName($args[0])))
		{
			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
			return false;
		}
		
		Shadowrun4::addPlayer($target);
		
		$bot->reply(sprintf('The player %s has been loaded into memory.', $args[0]));
		return true;
	}
}
?>