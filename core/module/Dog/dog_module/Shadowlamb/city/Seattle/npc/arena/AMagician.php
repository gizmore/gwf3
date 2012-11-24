<?php
final class Seattle_AMagician extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Magician'; }
//	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ElvenStaff',
			'armor' => 'FineRobe',
			'helmet' => 'ElvenCap',
			'legs' => 'ElvenTrousers',
		);
	}
	public function getNPCInventory() { return array('FirstAid'); }
	public function getNPCSpells() { return array('freeze'=>2,'firebolt'=>2); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => 2,
			'quickness' => 5,
			'magic'  => 8,
			'intelligence' => 8,
			'wisdom' => 4,
			'distance' => 12,
			'base_hp' => 16,
			'nuyen' => 90,
			'base_mp' => 20,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$nuyen = 900;
		$key = 'SEATTLE_ARENA_N';
		$player->setConst($key, $player->getConst($key)+1);
		$player->msg('5125', array(Shadowfunc::displayNuyen($nuyen)));
// 		$player->message("The fight is over. The director hands you $nuyen Nuyen.");
		$player->giveNuyen($nuyen);
		return array();
	}
}
?>