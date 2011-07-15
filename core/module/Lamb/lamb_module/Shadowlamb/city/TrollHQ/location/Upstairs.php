<?php
final class TrollHQ_Upstairs extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return "You found a stair that leads up to the second floor."; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleport($player, 'TrollHQ2_Downstairs', 30);
	}
}
?>
