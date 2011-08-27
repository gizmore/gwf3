<?php
final class Seattle_BlackOp extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Polizia'; }
	public function isNPCDropping(SR_Party $party) { return false; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		$bad_karma = $party->getSum('bad_karma', true);
		$perc = ($bad_karma/50) * 100;
		return Common::clamp($perc, 0.0, 100.0);
	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'William911',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'CopBoots',
			'helmet' => 'KevlarHelmet',
			'shield' => 'KevlarShield',
		);
	}
	public function getNPCInventory() { return array('Stimpatch','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 12),
			'melee' => rand(1, 2),
			'firearms' => rand(3, 4),
			'pistols' => rand(4, 4),
			'sharpshooter' => rand(5, 6),
			'nuyen' => rand(10, 20),
			'base_hp' => rand(10, 20),
		);
	}
}
?>