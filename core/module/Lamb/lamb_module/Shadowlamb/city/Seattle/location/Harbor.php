<?php
final class Seattle_Harbor extends SR_Entrance
{
	public function getFoundPercentage() { return 40.00; }
// 	public function getEnterText(SR_Player $player) {}
// 	public function getFoundText(SR_Player $player) { return 'You found the Seattle harbor. A big area for ships and stuff.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getExitLocation() { return 'Harbor_Exit'; }
}
?>