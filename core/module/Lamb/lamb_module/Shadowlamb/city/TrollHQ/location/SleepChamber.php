<?php
final class TrollHQ_SleepChamber extends SR_SearchRoom
{
	public function getAreaSize() { return 18; }
	public function getEnterText(SR_Player $player) { return "You enter the room and see various creatures sleeping."; }
	public function getFoundText(SR_Player $player) { return "You found a door that has \"Do not disturb\" engraved."; }
	public function getLockLevel() { return 0; }
	public function getFoundPercentage() { return 50.0; }
	public function getSearchLevel() { return 5; }
	
	public function onEnter(SR_Player $player)
	{
		if (parent::onEnter($player))
		{
			if (!$player->hasConst('THQ_SC1'))
			{
				$player->getParty()->notice('Some of the creatures awake and attack!');
				$player->setConst('THQ_SC1', 1);
				SR_NPC::createEnemyParty('Delaware_Ork','Delaware_Troll','Delaware_Troll','Delaware_Ork')->fight($player->getParty());
			}
		}
		return true;
	}
}
?>