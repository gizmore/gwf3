<?php
final class Hideout_Room2 extends SR_Location
{
	public function getAreaSize() { return 12; }
	public function getFoundPercentage() { return 100; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found another room. It seems to be quiet in there.'; }
// 	public function getEnterText(SR_Player $player) { return 'You see three Lamers sleeping.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getLeaderCommands(SR_Player $player) { return array_merge(parent::getLeaderCommands($player), array('wakeup')); }
	
	public function on_wakeup(SR_Player $player, array $args)
	{
		if (!$player->hasTemp('HIDE_R2_ONCE'))
		{
			$player->setTemp('HIDE_R2_ONCE', 1);
			$party = $player->getParty();
			$this->partyMessage($player, 'wakeup');
// 			$party->notice('You wake the three lamers kindly... As they realize what`s happening they attack.');
			SR_NPC::createEnemyParty('Redmond_Lamer','Redmond_Lamer','Redmond_Lamer')->fight($party, true);
		}
		else
		{
			$player->message($this->lang($player, 'no_wake'));
// 			$player->message("There are no lamers to wake.");
		}
		return true;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$party->getLeader()->unsetTemp('HIDE_R2_ONCE');
		return parent::onCityEnter($party);
	}
}
?>