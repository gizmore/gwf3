<?php
final class Shadowcmd_drop extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if ( (count($args) < 1) || (count($args) > 2) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'drop'));
			return false;
		}
		
		if (false === ($item = $player->getInvItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		
		
		$amt = count($args) === 2 ? (int)$args[1] : 1;
		
		if ($amt < 1) {
			$bot->reply('You can only drop a positive amount of items.');
			return false;
		}
		
		if (!$item->isItemDropable()) {
			$bot->reply('You should not drop that item.');
			return false;
		}
		
		if ($amt > $item->getAmount()) {
			$bot->reply('You don\'t have that much '.$item->getName().' in one itemid (ammo should work).');
			return false;
		}
		
		if (false === $item->useAmount($player, $amt)) {
			$bot->reply('Database error 9.');
			return false;
		}
		
		$bot->reply(sprintf('You got rid of %d %s.',$amt, $item->getItemName()));
		$player->modify();
		return true;
	}
}
?>
