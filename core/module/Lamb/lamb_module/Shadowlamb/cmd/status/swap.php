<?php
final class Shadowcmd_swap extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 2)
		{
			self::reply($player, Shadowhelp::getHelp($player, 'swap'));
			return false;
		}

		$ret = $player->swapInvItems($args[0], $args[1]);

		if($ret < 0 && $ret > -3)
		{
			self::rply($player, '1020', array($args[-$ret-1]));
			return false;
// 			$bot->reply("You don\'t have " . $args[-$ret-1]);
		}
		elseif($ret == -3)
		{
			self::rply($player, '1030');
			return false;
// 			$bot->reply("You can't swap " . $args[0] . " with itself.");
		}
		else
		{
			return self::rply($player, '5063', $args);
// 			$bot->reply("Items " . $args[0] . " and " . $args[1] . " have been swapped.");
		}

// 		return true;
	}
}
?>
