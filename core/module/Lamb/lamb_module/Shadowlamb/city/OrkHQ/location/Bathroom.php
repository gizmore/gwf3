<?php
final class OrkHQ_Bathroom extends SR_Location
{
	public function getAreaSize() { return 8; }
	public function getFoundPercentage() { return 60; }
	public function getFoundText(SR_Player $player) { return 'You locate the bathroom.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the bathroom and suprise a drunken Ork.'; }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$party = $player->getParty();
		SR_NPC::createEnemyParty('Redmond_Ork')->fight($party, true);
	}
}
?>