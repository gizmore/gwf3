<?php
final class NySoft_ServerRoom extends SR_SearchRoom
{
	public function getFoundText(SR_Player $player) { return 'It seems like you found a server room. "BINGO", you think to yourself, while looking innocent.'; }
	public function getLockLevel() { return 7; } 
	public function getEnterText(SR_Player $player) { return 'You enter a shady room and hear the buzzing of computers doing their job.';
	}
	
}
?>