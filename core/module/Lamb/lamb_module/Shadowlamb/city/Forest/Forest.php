<?php
final class Forest extends SR_City
{
	public function getArriveText(SR_Player $player) { return $this->lang($player, 'arrive'); }
	public function getMinLevel() { return 21; }
	public function getSquareKM() { return 40; }
	public function getImportNPCS() { return array('Seattle_Robber', 'Redmond_Ork', 'TrollCellar_Imp', 'TrollCellar_CaveTroll', 'Vegas_Troll'); }
	public function getRespawnLocation(SR_Player $player)
	{
		return Shadowrun4::getCity('Seattle')->getRespawnLocation($player);
	}
}
?>