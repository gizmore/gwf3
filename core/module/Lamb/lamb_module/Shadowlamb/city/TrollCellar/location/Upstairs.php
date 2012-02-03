<?php
final class TrollCellar_Upstairs extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return "You found a stair that leads up to the building again."; }
	public function getFoundPercentage() { return 50.00; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleportOutside($player, 'TrollHQ_Downstairs');
	}
	
}
?>
