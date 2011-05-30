<?php
final class Shadowcmd_gmc extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		require_once Lamb::DIR.'lamb_module/Shadowlamb/Shadowcron.php';
		Shadowcron::onCronjob();
	}
}
?>
