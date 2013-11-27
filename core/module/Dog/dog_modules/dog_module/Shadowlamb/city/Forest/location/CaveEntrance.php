<?php
final class Forest_CaveEntrance extends SR_Entrance
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getFoundPercentage() { return 25; }
	
	public function getExitLocation() { return 'Cave_Exit'; }
	
// 	public function onEnter(SR_Player $player)
// 	{
// 		$this->teleportInside($player, 'Cave_Exit');
// 	}
}
?>
