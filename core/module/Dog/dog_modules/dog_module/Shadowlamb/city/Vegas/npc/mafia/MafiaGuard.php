<?php
require_once 'Mafiosi.php';
final class Vegas_MafiaGuard extends Vegas_Mafiosi
{
	public function getNPCLoot(SR_Player $player)
	{
		SR_PlayerVar::increaseVal($player, 'mgkills', 1);
		return array();
	}
}
?>
