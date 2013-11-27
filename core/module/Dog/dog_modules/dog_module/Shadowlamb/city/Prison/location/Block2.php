<?php
final class Prison_Block2 extends SR_Entrance
{
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the entry to cell block 2. Not a beautiful place to live.'; }
	public function getEnterText(SR_Player $player) { return 'You enter cell block 2.'; }
	public function getExitLocation() { return 'PrisonB2_Exit'; }
}
?>