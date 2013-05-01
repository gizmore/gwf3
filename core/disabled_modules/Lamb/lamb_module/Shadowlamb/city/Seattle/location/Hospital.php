<?php
final class Seattle_Hospital extends SR_Hospital
{
	public function getHealPrice() { return 120; }
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Doctor'); }
	
	public function getStoreItems(SR_Player $player)
	{
		$back = array();
		$rep = $player->get('reputation');
		
		$back[] = array('Headcomputer');
		$back[] = array('SmartGoggles');
		$back[] = array('Cybermuscles');
		$back[] = array('CybermusclesV2');
		$back[] = array('DermalPlates');
		if ($rep >= 2) $back[] = array('DermalPlatesV2');
		$back[] = array('WiredReflexes');
		if ($rep >= 2) $back[] = array('WiredReflexesV2');
		$back[] = array('Sporn');
		
		return $back;
	}
}
?>
