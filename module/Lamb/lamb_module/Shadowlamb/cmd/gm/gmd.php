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
		if (false === ($remote = Shadowrun4::getPlayerByShortName($username)))
		{
			$player->message('This player is not in memory.');
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
