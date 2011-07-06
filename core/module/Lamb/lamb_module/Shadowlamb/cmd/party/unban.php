<?php
require_once 'ban.php';
final class Shadowcmd_unban extends Shadowcmd_ban
{
	public static function execute(SR_Player $player, array $args)
	{
		self::onBan($player, $args, false);
	}
}
?>
