<?php
final class Shadowcmd_gmlangfiles extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) !== 1) || ($args[0] !== 'DOIT!') )
		{
			return $bot->reply(Shadowhelp::getHelp($player, 'Shadowcmd_gmlangfiles'));
		}
		
		if (false === SR_Install::onCreateLangFiles())
		{
			return $bot->reply('An error occured!');
		}
		
		return $bot->reply('Lang files have been recreated. use .langflush to reload.');
	}
}
?>