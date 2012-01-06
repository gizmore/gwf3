<?php
require_once 'enable.php';
final class Shadowcmd_disable extends Shadowcmd_enable
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'disable'));
			return false;
		}
		
		switch ($args[0])
		{
			case 'help': return self::onEnable($player, SR_Player::HELP, false, 'Help'); break;
			case 'notice': return self::onToggleMessageType($player, SR_Player::PRIVMSG); break;
			case 'privmsg': return self::onToggleMessageType($player, SR_Player::NOTICE); break;				
			case 'lock': return self::onEnable($player, SR_Player::LOCKED, false, 'Equipment Lock'); break;
			case 'bot': return self::onEnable($player, SR_Player::PLAYER_BOT, false, 'Player Botflag'); break;
			case 'norl': return self::onEnable($player, SR_Player::NO_RL, false, 'Permleader'); break;
			default: $bot->reply(Shadowhelp::getHelp($player, 'disable'));
		}
		
		return false;
	}
}
?>
