<?php
final class Shadowcmd_examine extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'examine'));
			return false;
		}
		
		if (false === ($item = $player->getItem($args[0])))
		{
			self::rply($player, '1020', array($args[0])); # don't know item
			return false;
		}
		
		return self::rply($player, '5049', array($item->getItemInfo($player)));
	}
}
?>
