<?php
final class Shadowcmd_motd extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$path = Shadowrun4::getShadowDir().'shadowlamb_motd.txt';
		if (!is_readable($path) || false === ($motd = file_get_contents($path)))
		{
			return $bot->reply('Can not read MOTD file');
		}
		return $bot->rply('5249', array($motd));
// 		$bot->reply(sprintf('Message of the day: %s', $motd));
	}
}
?>