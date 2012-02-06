<?php
/**
 * Delete a character.
 * @author gizmore
 */
final class Shadowcmd_reset extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (!$player->getParty()->isIdle())
		{
			$player->msg('1033');
// 			$player->message('Your party has to be idle to reset players. Try #part to leave your party.');
			return false;
		}

		$c = Shadowrun4::SR_SHORTCUT;
		$bot = Shadowrap::instance($player);
		
		if ( (count($args)===1) && ($args[0]==='i_am_sure') )
		{
			$player->deletePlayer();
			$player->msg('5245');
// 			$player->message(sprintf('Your character has been deleted. You may issue %sstart again.', $c));
		}
		else
		{
			$player->msg('5246');
// 			$bot->reply(sprintf('This will completely delete your character. Type "%sreset i_am_sure" to confirm.', $c));
		}
		
		return true;
	}
}
?>