<?php
final class Shadowcmd_gmc extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		require_once Shadowrun4::getShadowDir().'dog_module/Shadowlamb/Shadowcron.php';
		#Shadowcron::onCronjob();
	}
}
?>
