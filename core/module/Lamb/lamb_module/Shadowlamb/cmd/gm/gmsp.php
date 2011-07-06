<?php
final class Shadowcmd_gmsp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gmsp'));
			return false;
		}
		
		if (false === ($spell = SR_Spell::getSpell($args[1])))
		{
			$bot->reply("The spell {$args[1]} is unknown.");
			return false;
		};
		
		$server = $player->getUser()->getServer();
		
		if (false === ($user = $server->getUserByNickname($args[0])))
		{
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		
		if (false === ($target = Shadowrun4::getPlayerByUID($user->getID())))
//		if (false === ($target = Shadowrun4::getPlayerForUser($user))) {
		{
			$bot->reply(sprintf('The player %s is unknown.', $user->getName()));
			return false;
		}

		if (false !== ($error = self::checkCreated($target)))
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		$target->levelupSpell($spell->getName(), 1);
		$target->modify();
		
		return $bot->reply(sprintf('The target got increased spells!'));
	}
}
?>
