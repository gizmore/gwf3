<?php
class Shadowcmd_enable extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'enable'));
			return false;
		}
		
		switch ($args[0])
		{
			case 'help': return self::onEnable($player, SR_Player::HELP, true, 'Help'); break;
			case 'notice': return self::onToggleMessageType($player, SR_Player::NOTICE); break;
			case 'privmsg': return self::onToggleMessageType($player, SR_Player::PRIVMSG); break;
			default: $bot->reply(Shadowhelp::getHelp($player, 'enable'));
		}
		return false;
	}

	protected static function onEnable(SR_Player $player, $bit, $bool, $name)
	{
		$text = $bool === true ? 'enabled' : 'disabled';
		
		$old = $player->isOptionEnabled($bit);
		if ($bool === $old) {
			$player->message(sprintf('%s has been already %s.', $name, $text));
			return true;
		}
		if (false === $player->saveOption($bit, $bool)) {
			return false;
		}
		$player->message(sprintf('%s has been %s for your character.', $name, $text));
		return true;
	}
	
	protected static function onToggleMessageType(SR_Player $player, $msgtype)
	{
		static $typetext = array(
			SR_Player::NOTICE => 'NOTICE',
			SR_Player::PRIVMSG => 'PRIVMSG',
		);
		$bits = SR_Player::NOTICE|SR_Player::PRIVMSG;
		if (($player->getOptions()&$bits) === $msgtype) {
			Lamb::instance()->reply('Your Shadowlamb message type was already set to '.$typetext[$msgtype].'.');
			return true;
		}
		$player->saveOption($bits, false);
		$player->saveOption($msgtype, true);
		Lamb::instance()->reply('Your Shadowlamb message type has been set to: '.$typetext[$msgtype].'.');
		$player->message('This is a test.');
		return true;
	}
}
?>
