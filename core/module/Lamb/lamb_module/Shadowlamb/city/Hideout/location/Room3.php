<?php
final class Hideout_Room3 extends SR_Location
{
	public function getAreaSize() { return 28; }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText(SR_Player $player) { return 'You found another room. It seems to be quiet in there.'; }
	public function getEnterText(SR_Player $player) { return 'It`s not quiet. You see a big punk and three others sitting on a table. They Attack!'; }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$party = $player->getParty();
		SR_NPC::createEnemyParty('Redmond_Ueberpunk','Redmond_Cyberpunk','Redmond_Cyberpunk','Redmond_Cyberpunk')->fight($party, true);
	}
}
?>