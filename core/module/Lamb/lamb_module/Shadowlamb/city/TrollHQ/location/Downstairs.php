<?php
final class TrollHQ_Downstairs extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return "You found a stair that leads down to the cellars."; }
	public function getFoundPercentage() { return 50.00; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleportOutside($player, 'TrollCellar_Upstairs');
	}
}
?>
