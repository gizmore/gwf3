<?php
final class Shadowcmd_attributes extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowfunc::getAttributes($player, '5004'));
	}
}
?>