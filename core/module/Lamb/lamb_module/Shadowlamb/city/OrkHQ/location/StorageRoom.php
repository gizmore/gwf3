<?php
final class OrkHQ_StorageRoom extends SR_SearchRoom
{
	public function getAreaSize() { return 18; }
	public function getSearchLevel() { return 6; }
	public function getFoundPercentage() { return 80; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
// 	public function getFoundText(SR_Player $player) { return 'You found another room. You smell rotten meat from the inside.'; }
	
	public function getEnterText(SR_Player $player)
	{
		if ($player->hasTemp('OHQ_SR_ONCE'))
		{
			return $this->lang($player, 'enter1');
// 			return 'You enter the storage room. You see a lot of garbage.';
		}
		else
		{
			return $this->lang($player, 'enter2');
// 			return 'You enter the storage room. You see a fat ork and attack him.';
		}
	}
	
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "In this location you can use {$c}search, to look for hidden items."; }
	
	public function onEnter(SR_Player $player)
	{
		parent::onEnter($player);
		
		if (!$player->hasTemp('OHQ_SR_ONCE'))
		{
			$player->setTemp('OHQ_SR_ONCE', 1);
			$party = $player->getParty();
			SR_NPC::createEnemyParty('OrkHQ_FatOrk')->fight($party, true);
		}
		
		return true;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$party->getLeader()->unsetTemp('OHQ_SR_ONCE');
		return parent::onCityEnter($party);
	}
}
?>
