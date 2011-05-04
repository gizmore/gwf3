<?php
final class OrkHQ_SnookerRoom extends SR_Location
{
	public function getFoundPercentage() { return 100; }
	public function getFoundText() { return 'From the distance you hear some Orks playing snooker.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the room and it does not take them too long to attack you.'; }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$party = $player->getParty();
		SR_NPC::createEnemyParty(array('Redmond_Ork', 'Redmond_Ork', 'Redmond_Ork', 'Redmond_Ork'))->fight($party, true);
	}
	
}
?>