<?php
final class Seattle_AToughGuy extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Tough Guy'; }
//	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhawk',
			'armor' => 'ChainVest',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
			'boots' => 'Sneakers'
		);
	}
	public function getNPCInventory() { return array('Ammo_11mm', 'Ammo_11mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'pistols' => 2,
			'strength' => 2,
			'quickness' => 3,
			'firearms'  => 3,
			'distance' => 10,
			'sharpshooter' => 1,
			'nuyen' => 70,
			'base_hp' => 20,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$nuyen = 500;
		$key = 'SEATTLE_ARENA_N';
		$player->setConst($key, $player->getConst($key)+1);
		$player->message("The fight is over. The director hands you $nuyen Nuyen.");
		$player->giveNuyen($nuyen);
		return array();
	}
}
?>