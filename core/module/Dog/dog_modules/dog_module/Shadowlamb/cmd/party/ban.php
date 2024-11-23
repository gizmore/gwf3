<?php
class Shadowcmd_ban extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		self::onBan($player, $args, true);
	}

	protected static function onBan(SR_Player $player, array $args, $bool)
	{
// 		$bot = Shadowrap::instance($player);
		if (count($args) > 1)
		{
			$player->message(Shadowhelp::getHelp($player, $bool===true?'ban':'unban'));
// 			$bot->reply(Shadowhelp::getHelp($player, $bool===true?'ban':'unban'));
			return false;
		}
		
		$p = $player->getParty();
		if (count($args) === 0)
		{
			$p->banAll($bool);
			$key = $bool === true ? '5065' : '5066';
			return $player->msg($key);
// 			if ($bool === true)
// 			{
// 				$msg = 'Your party does not accept new members anymore.';
// 			}
// 			else
// 			{
// 				$msg = 'Your party does accept new members again.';
// 			}
// 			$bot->reply($msg);
// 			return true;
		}
		
		if (false === ($target = Shadowrun4::getPlayerByName($args[0])))
		{
			$player->msg('1017');
// 			$bot->reply('This player is unknown or not in memory.');
			return false;
		}
		
		$args = array($target->getName());
		$key = $bool === true ? '5067' : '5068';
		if ($bool === true)
		{
			$p->ban($target);
// 			$bot->reply(sprintf('%s has been banned from the party.', $target->getName()));
		}
		else
		{
			$p->unban($target);
// 			$bot->reply(sprintf('%s may now join your party again.', $target->getName()));
		}
// 		return true;

		return $player->msg($key, $args);
	}
}
?>
