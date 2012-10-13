<?php
final class Forest_WoodElve extends SR_NPC
{
	public function getNPCLevel() { return 25; }
	public function getNPCPlayerName() { return 'AngryWoodElve'; }
	public function getNPCMeetPercent(SR_Party $party) { return 12.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'amulet' => 'ElvenTag_of_bows:1',
			'armor' => 'ElvenVest',
			'boots' => 'ElvenBoots',
			'legs' => 'ElvenTrousers',
			'weapon' => 'ElvenBow',
			'shield' => 'ElvenShield',
			'gloves' => 'ElvenGloves',
			'helmet' => 'ElvenCap',
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'heal' => 2,
		);
	}
	
	public function getNPCInventory()
	{
		return array('100xAmmo_Arrow');
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'woodelve',
			'gender' => 'male',
			'melee' => rand(2, 6),
			'strength' => rand(2, 6),
			'quickness' => rand(8, 10),
			'distance' => rand(16, 24),
			'sharpshooter' => rand(6, 10),
			'bows' => rand(8, 12),
			'firearms' => rand(7, 10),
			'nuyen' => rand(20, 60),
			'base_hp' => rand(15, 25),
			'magic' => rand(5, 8),
			'intelligence' => rand(5, 8),
			'wisdom' => rand(5, 8),
		);
	}
}
?>
