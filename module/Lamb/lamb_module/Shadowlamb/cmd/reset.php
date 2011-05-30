<?php
/**
 * Delete a character.
 * @author gizmore
 */
final class Shadowcmd_reset extends Shadowcmd
{
	const TEMP_KEY = 'CMD_RESET_CONFIRM';
	public static function execute(SR_Player $player, array $args)
	{
		if (!$player->getParty()->isIdle())
		{
			$player->message('Your party has to be idle to reset players. Try #part to leave your party.');
			return false;
		}

		$c = Shadowrun4::SR_SHORTCUT;
		$bot = Shadowrap::instance($player);
		$key = self::TEMP_KEY;
		
		if (!$player->hasTemp($key))
		{
			$bot->reply(sprintf('This will completely delete your character. Type %sreset again to confirm.', $c));
			$player->setTemp($key, 1);
		}
		
		else
		{
			$player->deletePlayer();
			$player->message(sprintf('Your character has been deleted. You may issue %sstart again.', $c));
			$player->unsetTemp($key);
		}
		
		return true;
	}
}
?>