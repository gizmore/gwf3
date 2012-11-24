<?php
final class Seattle_Forest extends SR_Entrance
{
	public function getFoundPercentage() { return 15.0; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getExitLocation() { return 'Forest_Exit'; }
}
?>
