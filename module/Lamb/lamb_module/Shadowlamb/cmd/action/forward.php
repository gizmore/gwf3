<?php
final class Shadowcmd_forward extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->getParty()->forward($player, SR_Player::FORWARD_TIME);
	}
}
?>
