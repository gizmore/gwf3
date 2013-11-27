<?php
final class Prison_GrayOp extends SR_NPC
{
	public function getNPCLevel() { return 0; }
	public function getNPCPlayerName() { return 'Polizia'; }
	public function isNPCDropping(SR_Party $party) { return false; }
	public function getNPCMeetPercent(SR_Party $party)
	{
		if ($this->getNPCCityClass()->isAlert($party))
		{
			return 300;
		}

		$bad_karma = $party->getSum('bad_karma', true);
		$perc = ($bad_karma/5) * 100;
		return Common::clamp($perc, 0.0, 100.0);

	}
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhawk',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'CopBoots',
			'helmet' => 'KevlarHelmet',
			'shield' => 'KevlarShield',
		);
	}
	public function getNPCInventory() { return array('Stimpatch','Ammo_11mm','Ammo_11mm','Ammo_11mm','Ammo_11mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'halfelve',
			'gender' => 'male',
			'strength' => rand(3, 4),
			'quickness' => rand(6, 8),
			'distance' => rand(8, 12),
			'melee' => rand(1, 2),
			'firearms' => rand(5, 6),
			'pistols' => rand(5, 6),
			'sharpshooter' => rand(6, 8),
			'nuyen' => rand(3, 13),
			'base_hp' => rand(20, 30),
		);
	}
}
?>