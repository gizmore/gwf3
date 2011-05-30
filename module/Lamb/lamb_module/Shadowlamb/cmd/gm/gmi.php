<?php
final class Shadowcmd_gmi extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'gmi'));
			return false;
		}
		
		$server = $player->getUser()->getServer();
		
		if (false === ($user = $server->getUserByNickname($args[0]))) {
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		
		if (false === ($target = Shadowrun4::getPlayerByUID($user->getID()))) {
//		if (false === ($target = Shadowrun4::getPlayerForUser($user))) {
			$bot->reply(sprintf('The player %s is unknown.', $user->getName()));
			return false;
		}

		if (false !== ($error = self::checkCreated($target))) {
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		if (false === ($item = SR_Item::createByName($args[1]))) {
			$bot->reply(sprintf('The item %s could not be created.', $args[1]));
			return false;
		} 
		
		if (isset($args[2]))
		{
			$item->saveVar('sr4it_amount', intval($args[2]));
		}
		
		$target->giveItems($item);
		
		return true;
	}
}
?>
