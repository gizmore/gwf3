<?php
final class Seattle_ASecOrk extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Security Ork'; }
//	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'T250Shotgun',
			'armor' => 'ChainVest',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
		);
	}
	public function getNPCInventory() { return array('Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun', 'Ammo_Shotgun'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'ork',
			'gender' => 'male',
			'shotguns' => 2,
			'strength' => 4,
			'quickness' => 3,
			'firearms'  => 3,
			'distance' => 10,
			'sharpshooter' => 2,
			'nuyen' => 80,
			'base_hp' => 28,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$nuyen = 600;
		$key = 'SEATTLE_ARENA_N';
		$player->setConst($key, $player->getConst($key)+1);
		$player->message("The fight is over. The director hands you $nuyen Nuyen.");
		$player->giveNuyen($nuyen);
		return array();
	}
}
?>