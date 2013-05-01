<?php
final class Cave extends SR_Dungeon
{
	public function getExploreTime() { return 300; }
	public function getGotoTime() { return 120; }
	
	public function getArriveText(SR_Player $player) { return $this->lang($player, 'arrive'); }
	public function getSquareKM() { return 6; }
	public function getMinLevel() { return 21; }
	
	public function getCityLocation() { return 'Forest'; }
	
	public function getImportNPCS() {
		return array('Seattle_Robber', 'Redmond_Ork', 'TrollCellar_Imp', 'TrollCellar_CaveTroll', 'Vegas_Troll', 'Forest_SmallZombieBear');
	}
	
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
	
	public function onEvents(SR_Party $party)
	{
		return false;
	}
}
?>