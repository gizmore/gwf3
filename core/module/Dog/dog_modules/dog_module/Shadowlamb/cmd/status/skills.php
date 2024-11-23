<?php
final class Shadowcmd_skills extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->message(Shadowfunc::getSkills($player, '5006'));
	}
}
?>