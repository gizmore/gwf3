<?php
final class Chicago_JJKiller extends SR_NPC
{
	public function getNPCLevel() { return 19; }
	public function getNPCPlayerName() { return 'KillerPuppet'; }
	public function getNPCMeetPercent(SR_Party $party) { return 43.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'StuddedVest',
			'helmet' => 'LeatherCap',
			'boots' => 'LeatherBoots',
			'legs' => 'Trousers',
			'weapon' => 'Knife',
		);
	}
	
	public function getNPCInventory() { return array('Pizza'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => rand(12, 15),
			'strength' => rand(4, 5),
			'quickness' => rand(12, 18),
			'distance' => rand(1, 9),
			'sharpshooter' => rand(18, 24),
			'nuyen' => rand(10, 30),
			'spelldef' => rand(200,300), # XXX SpellDef test
			'base_hp' => rand(15, 35),
		);
	}
}
?>