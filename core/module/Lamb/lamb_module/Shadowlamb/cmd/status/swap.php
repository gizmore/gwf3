<?php
final class Shadowcmd_swap extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);

		if (count($args) !== 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'swap'));
			return false;
		}

		$ret = $player->swapInvItems($args[0],$args[1]);

		if($ret < 0 && $ret > -3){
			$bot->reply("You dont have " . $args[-$ret-1]);
		}elseif($ret == -3){
			$bot->reply("You can't swap " . $args[0] . " with itself");
		}else{
			$bot->reply("Items " . $args[0] . " and " . $args[1] . " have been swapped.");
		}

		return true;
	}
}
?>
