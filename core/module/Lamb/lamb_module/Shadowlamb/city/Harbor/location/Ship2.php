<?php
final class Harbor_Ship2 extends SR_Tower
{
	public function getAreaSize() { return 160; }
	
	public function getFoundPercentage() { return 60.0; }
	public function getEnterText(SR_Player $player) { return 'You enter the ship named "Paninsula" ...'; }
	public function getFoundText(SR_Player $player) { return 'You found a freighter-ship called "Paninsula".'; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		
		$player->message('You cannot find any open entrance to the ship ... yet.');
		
		return false;
	}
}
?>