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
			self::deletePlayer($player);
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
	
	private static function deletePlayer(SR_Player $player)
	{
		$epname = GDO::escape($player->getName());
		
		if (false === GDO::table('SR_BazarShop')->deleteWhere("sr4bs_pname='$epname'"))
		{
			return false;
		}
		if (false === GDO::table('SR_BazarItem')->deleteWhere("sr4ba_pname='$epname'"))
		{
			return false;
		}
	}
}
?>