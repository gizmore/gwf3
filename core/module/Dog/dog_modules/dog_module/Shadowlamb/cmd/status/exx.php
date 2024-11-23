<?php
/**
 * Packed version of #examine for safing bandwidth in Shadowclient.
 * @author gizmore
 */
final class Shadowcmd_exx extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 1)
		{
			return false;
		}

		if (false === ($item = $player->getItem($args[0])))
		{
			$player->msg('1020', array($args[0])); # don't know item
			return false;
		}
		
		return $player->msg('9001', array($item->displayPacked($player)));
	}
}
?>
