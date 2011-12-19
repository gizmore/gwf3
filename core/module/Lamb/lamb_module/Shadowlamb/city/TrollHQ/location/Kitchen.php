<?php
final class TrollHQ_Kitchen extends SR_SearchRoom
{
	public function getAreaSize() { return 15; }
	public function getSearchLevel() { return 5; }
	public function getSearchMaxAttemps() { return 2; }
	public function getFoundPercentage() { return 50.00; }
	
	public function getSearchLoot(SR_Player $player)
	{
		if (rand(0,2))
		{
			return array(SR_Item::createByName('Bacon'));
		}
		return parent::getSearchLoot($player);
	}
	
	public function getEnterText(SR_Player $player) { return "You enter the kitchen, a room of dust and ... A cook!"; }
	public function getFoundText(SR_Player $player) { return "You found a room with a gilbed door. Probably the kitchen."; }
	
	public function onEnter(SR_Player $player)
	{
		if (parent::onEnter($player))
		{
			SR_NPC::createEnemyParty('TrollHQ_ChiefCook')->fight($player->getParty());
		}
		return true;
	}
}
?>
