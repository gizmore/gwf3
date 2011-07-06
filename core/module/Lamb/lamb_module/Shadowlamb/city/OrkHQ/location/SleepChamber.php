<?php
final class OrkHQ_SleepChamber extends SR_Location
{
	public function getFoundPercentage() { return 90; }
	public function getFoundText(SR_Player $player) { return 'You find a closed door. You hear snorting noise from the inside-'; }
	public function getEnterText(SR_Player $player) { return 'You enter the room and see a Troll sleeping. You try to be quiet, but the Troll numbles, awakes, and spots you with a half closed eye.'; }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		
		$party = $player->getParty();
		
		SR_NPC::createEnemyParty('OrkHQ_HalfTroll')->fight($party, true);
	}
	
}
?>