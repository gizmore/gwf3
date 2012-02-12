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
		
		$p = $player->getParty();
		if (false !== ($loc = $p->getLocationClass(SR_Party::ACTION_INSIDE)))
		{
			if ($loc instanceof SR_Store)
			{
				if (false !== ($item = $loc->getStoreItem($player, $args[0])))
				{
					return self::rply($player, '5049', array($item->getItemInfo($player)));
				}
			}
		}
		
		if (false === ($item = $player->getItem($args[0])))
		{
			self::rply($player, '1020', array($args[0]));
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		
		return self::rply($player, '5049', array($item->getItemInfo($player)));
	}
}
?>
