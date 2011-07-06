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
			$bot->reply('You don`t have that item.');
			return false;
		}
		
		return $bot->reply($item->getItemInfo($player));
	}
}
?>
