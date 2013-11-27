<?php
final class Seattle_AElite extends SR_NPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return 'Elite Soldier'; }
//	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'HK227sVariant',
			'armor' => 'LightBodyArmor',
			'helmet' => 'CombatHelmet',
			'legs' => 'Trousers',
		);
	}
	public function getNPCInventory() { return array('Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Ammo_7mm', 'Flashbang', 'FirstAid'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'smgs' => 6,
			'strength' => 5,
			'quickness' => 5,
			'firearms'  => 6,
			'distance' => 10,
			'sharpshooter' => 4,
			'nuyen' => 100,
			'base_hp' => 30,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$nuyen = 1200;
		$key = 'SEATTLE_ARENA_N';
		$player->setConst($key, $player->getConst($key)+1);
		$player->msg('5125', array(Shadowfunc::displayNuyen($nuyen)));
// 		$player->message("The fight is over. The director hands you $nuyen Nuyen.");
		$player->giveNuyen($nuyen);
		return array();
	}
}
?>