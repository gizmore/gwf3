<?php
final class NySoft_Exit extends SR_Exit
{
	public function getEnterText(SR_Player $player) { return 'You enter the building.'; }
	public function getExitLocation() { return 'Delaware_NySoft'; }
	public function getFoundPercentage() { return 100; }
}
?>