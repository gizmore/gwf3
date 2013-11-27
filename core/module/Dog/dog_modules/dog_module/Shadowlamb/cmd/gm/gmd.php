<?php
/**
 * Execute a command in the name of a player.
 * @see Shadowcmd_npc
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
class Shadowcmd_gmd extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) < 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'gmd'));
			return false;
		}
		
		$username = array_shift($args);
		$remote = Shadowrun4::getPlayerByShortName($username);
		if ($remote === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if ($remote === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		return self::onRemote($player, $remote, $args);
	}
	
	/**
	 * Execute a remote command.
	 * @param SR_Player $player
	 * @param SR_Player $remote
	 * @param array $args
	 */
	public static function onRemote(SR_Player $player, SR_Player $remote, array $args)
	{
		# Enable remote output.
		$remote->setRemotePlayer($player);
		# Execute command.
		$back = Shadowcmd::onTrigger($remote, implode(' ', $args));
		# Disable remote output.
		$remote->unsetRemotePlayer();
		# Return result.
		return $back;
	}
}
?>
