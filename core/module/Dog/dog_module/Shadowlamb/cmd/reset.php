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
			$player->msg('1033'); # Your party is moving. Try this command when idle.
			return false;
		}

		if ( (count($args)===1) && ($args[0]==='i_am_sure') )
		{
			self::deletePlayer($player);
			$player->deletePlayer();
			$player->msg('5245'); # Your character has been deleted. You may issue #start again.'
		}
		else
		{
			$player->msg('5246'); # This will completely delete your character. Type "#reset i_am_sure" to confirm.
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