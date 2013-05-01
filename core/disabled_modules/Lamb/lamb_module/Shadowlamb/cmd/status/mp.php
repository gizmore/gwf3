<?php
require_once 'hp.php';
final class Shadowcmd_mp extends Shadowcmd_hp
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::onHPMP($player, 'mp', '5051');
	}
}
?>
