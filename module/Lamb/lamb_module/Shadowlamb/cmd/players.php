<?php
final class Shadowcmd_players extends Shadowcmd
{
	public function execute(SR_Player $player, array $args)
	{
		$players = Shadowrun4::getPlayers();
		var_dump($players);
	}
}
?>