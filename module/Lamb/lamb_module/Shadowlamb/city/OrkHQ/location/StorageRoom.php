<?php
final class OrkHQ_StorageRoom extends SR_SearchRoom
{
	public function getSearchLevel() { return 6; }
	public function getFoundPercentage() { return 80; }
	public function getFoundText(SR_Player $player) { return 'You found another room. You smell rotten meat from the inside.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the storage room. You see a fat ork and attack him.'; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "In this location you can use {$c}search, to look for hidden items."; }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		$party = $player->getParty();
		SR_NPC::createEnemyParty('OrkHQ_FatOrk')->fight($party, true);
	}
	
}
?>