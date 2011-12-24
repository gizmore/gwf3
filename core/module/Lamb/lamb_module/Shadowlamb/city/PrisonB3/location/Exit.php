<?php
final class PrisonB3_Exit extends SR_Tower
{
	public function getFoundText(SR_Player $player)
	{
		return "You found the exit to cell block 3.";
	}
	
	public function getFoundPercentage()
	{
		return 5.00;
	}
	
	public function onEnter(SR_Player $player)
	{
		return $this->teleport($player, 'Prison_Block3', 1);
	}
}
?>