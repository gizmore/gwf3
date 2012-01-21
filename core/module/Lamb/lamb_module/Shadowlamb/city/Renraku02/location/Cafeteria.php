<?php
final class Renraku02_Cafeteria extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) { return 'You enter the cafeteria ... And surprise four Renraku guards having a break.'; }
	public function getFoundText(SR_Player $player) { return 'You found a room labelled "Cafeteria".'; }
	public function getSearchLevel() { return 5; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		SR_NPC::createEnemyParty('Renraku02_Security', 'Renraku02_Security', 'Renraku02_Security', 'Renraku02_Security')->fight($party);
		return true;
	}
}
?>
