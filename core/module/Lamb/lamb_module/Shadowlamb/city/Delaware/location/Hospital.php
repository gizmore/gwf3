<?php
final class Delaware_Hospital extends SR_Hospital
{
	public function getHealPrice() { return 250; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Doctor'); }
	public function getStoreItems(SR_Player $player)
	{
		$back = array();
		$rep = $player->get('reputation');
		
		$back[] = array('Headcomputer');
		$back[] = array('SmartGoggles');
		$back[] = array('Cybermuscles');
		$back[] = array('CybermusclesV2');
		$back[] = array('CybermusclesV3');
		$back[] = array('DermalPlates');
		if ($rep >= 2) $back[] = array('DermalPlatesV2');
		$back[] = array('WiredReflexes');
		if ($rep >= 2) $back[] = array('WiredReflexesV2');
		$back[] = array('Sporn');
		
		return $back;
	}
}
?>
