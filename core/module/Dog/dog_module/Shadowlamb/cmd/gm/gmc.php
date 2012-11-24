<?php
final class Shadowcmd_gmc extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		require_once DOG_PATH.'dog_module/Shadowlamb/Shadowcron.php';
		#Shadowcron::onCronjob();
	}
}
?>
