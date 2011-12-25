<?php
final class Prison_Block2 extends SR_Tower
{
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found the entry to cell block 2. Not a beautiful place to live.'; }
	public function getEnterText(SR_Player $player) { return 'You enter cell block 2.'; }
	public function onEnter(SR_Player $player)
	{
		return $this->teleportInstant($player, 'PrisonB2_Exit', SR_Party::ACTION_INSIDE);
	}
}
?>