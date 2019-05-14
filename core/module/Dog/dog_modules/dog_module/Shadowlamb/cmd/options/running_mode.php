<?php
final class Shadowcmd_running_mode extends Shadowcmd
{
	const WORD = 'I_AM_RUNNER';
	
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (!$player->getParty()->isIdle())
		{
			$player->msg('1033');
// 			$player->message('Your party is moving. Try this command when idle.');
			return false;
		}
		
		if ($player->isRunner())
		{
			self::rply($player, '5075');
// 			$bot->reply('You are already playing running mode. Nice!');
		}
		elseif (count($args) === 0)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'rm'));
			self::rply($player, '5076', array('#rm '.self::WORD));
// 			$bot->reply('Type "#rm '.self::WORD.' to confirm.');
		}
		elseif ( (count($args) !== 1) || ($args[0] !== self::WORD) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'rm'));
		}
		elseif ($player->getBase('level') > $player->getBase('karma'))
		{
			self::rply($player, '1197', array($player->getBase('level'), $player->getBase('karma')));
// 			self::reply($player, "You need %s karma to switch to running mode, but you only have %s.");
// 			self::rply($player, '1034');
// 			$bot->reply('You cannot switch to running mode when you passed level 2.');
			return false;
		}
		else
		{
			$player->alterField('karma', -$player->getBase('level')); # cost karma
			$player->saveOption(SR_Player::RUNNING_MODE, true); # set to running mode
			self::rply($player, '5077');
			self::rply($player, '5078');
// 			$bot->reply('You are now playing running mode. This means unlimited stats but instant death. Good luck!');
// 			$bot->reply('It is advised you #enable norl now too, to prevent your char from being kidnapped with the #rl command!');
			return true;
		}
		return false;
	}
}
?>
