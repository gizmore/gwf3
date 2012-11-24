<?php
final class Shadowcmd_clan_message extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return SR_ClanHQ::onClanMessage($player, $args);
	}
}
?>