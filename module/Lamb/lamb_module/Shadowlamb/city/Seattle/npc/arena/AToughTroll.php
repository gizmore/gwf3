<?php
final class Seattle_AToughTroll extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'ToughTroll'; }
//	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Uzi',
			'armor' => 'KevlarVest',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
			'boots' => 'Sneakers'
		);
	}
	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'smgs' => 3,
			'strength' => 4,
			'quickness' => 3,
			'firearms'  => 5,
			'distance' => 10,
			'sharpshooter' => 1,
			'nuyen' => 120,
			'base_hp' => 28,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$nuyen = 1200;
		$key = 'SEATTLE_ARENA_N';
		$player->setConst($key, $player->getConst($key)+1);
		$player->message("The fight is over. The director hands you $nuyen Nuyen.");
		$player->giveNuyen($nuyen);
		return array();
	}
}
?>