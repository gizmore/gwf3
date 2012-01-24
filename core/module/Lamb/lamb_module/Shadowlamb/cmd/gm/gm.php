<?php
final class Shadowcmd_gm extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ((count($args) < 2) || (count($args) > 3)) {
			$bot->reply(Shadowhelp::getHelp($player, 'gm'));
			return false;
		}
		
		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if ($target === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		
//		$server = $player->getUser()->getServer();
//		
//		if (false === ($user = $server->getUserByNickname($args[0]))) {
//			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
//			return false;
//		}
//		
//		if (false === ($target = Shadowrun4::getPlayerForUser($user, false))) {
//			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
//			return false;
//		}

		if (false !== ($error = self::checkCreated($target))) {
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		$var = $args[1];
		if (!$target->hasVar('sr4pl_'.$var)) {
			$bot->reply(sprintf('The var %s does not exist.', $var));
			return false;
		}
		
		$old = $target->getVar('sr4pl_'.$var);
		
		if (count($args) === 2)
		{
			$bot->reply(sprintf('Var %s of %s is set to %s.', $var, $target->getUser()->getName(), $old));
			return true;
		}

		$new = $args[2];
		
		$target->updateField($var, $new);
		if ( $var === 'const_vars' )
		{
			$target->reloadConstVars();
		} else {
			$target->modify();
		}
		$bot->reply(sprintf('Set %s`s %s from %s to %s.', $target->getUser()->getName(), $var, $old, $new));
		return true;
	}
}
?>
