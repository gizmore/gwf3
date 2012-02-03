<?php
final class Prison_Block3 extends SR_Tower
{
// 	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the entry to cell block 3. It seems to be a dirty place.'; }
	
	public function onEnter(SR_Player $player)
	{
		$this->teleportInside($player, 'PrisonB3_Exit');
	}
}
?>