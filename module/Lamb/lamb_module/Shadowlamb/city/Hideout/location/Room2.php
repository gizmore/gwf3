<?php
final class Hideout_Room2 extends SR_Location
{
	public function getFoundPercentage() { return 100; }
	public function getFoundText() { return 'You found another room. It seems to be quiet in there.'; }
	public function getEnterText(SR_Player $player) { return 'You see two Lamers sleeping.'; }
	public function getLeaderCommands(SR_Player $player) { return array('wakeup'); }
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
	}
	
	public function on_wakeup(SR_Player $player, array $args)
	{
		$party = $player->getParty();
		$party->notice('You wake the two lamers kindly... as they realize what`s happening they attack.');
		SR_NPC::createEnemyParty('Redmond_Lamer','Redmond_Lamer')->fight($party, true);
	}
}
?>