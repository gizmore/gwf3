<?php
final class Shadowcmd_motd extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$path = Lamb::DIR.'lamb_module/Shadowlamb/shadowlamb_motd.txt';
		if (false === ($motd = @file_get_contents($path)))
		{
			$bot->reply('Can not read '.$path);
		}
		return $bot->rply('5249', array($motd));
// 		$bot->reply(sprintf('Message of the day: %s', $motd));
// 		return true;
	}
}
?>