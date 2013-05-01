<?php
final class Shadowcmd_show extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		# One arg is like examine.
		if (count($args) === 1)
		{
			return Shadowcmd_examine::execute($player, $args);
		}
		
		# Other than 2 args is error => help.
		if (count($args) !== 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'show'));
			return false;
		}
		
		# Try to get target.
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->msg('1028', array($args[0]));
// 			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}
		
		# Show to yourself is like examine.
		if ($target->getID() === $player->getID())
		{
			return Shadowcmd_examine::execute($player, array($args[1]));
		}
		
		# Try to get item.
		if (false === ($item = $player->getItem($args[1])))
		{
			$player->msg('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		
		return $target->msg('5062', array($player->displayName(), $item->getItemInfo($target)));
// 		$msg = sprintf('%s shows you: %s', $player->displayName(), $item->getItemInfo($player));
// 		return $target->message($msg);
	}
}
?>
