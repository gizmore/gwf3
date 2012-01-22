<?php
final class Delaware_NySoft extends SR_Tower
{
	public function getFoundPercentage() { return 25.00; }
	public function getFoundText(SR_Player $player) { return 'You found the NySoft headquarters in Delaware. They are into military software.'; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		$party->notice('Nice, their business is open.');
		$this->teleportInstant($player, 'NySoft_Exit', 'inside');
	}
}
?>
