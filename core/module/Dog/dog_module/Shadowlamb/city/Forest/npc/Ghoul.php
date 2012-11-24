<?php
final class Forest_Ghoul extends SR_NPC
{
	public function getNPCLevel() { return 23; }
	public function getNPCPlayerName() { return 'Ghoul'; }
	public function getNPCMeetPercent(SR_Party $party) { return 12.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('Flail','MorningStar'),
			'armor' => 'ChainMail',
			'helmet' => 'ChainHelmet',
			'shield' => 'SmallShield',
			'boots' => 'ChainBoots',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => rand(9, 11),
			'ninja' => rand(2, 4),
			'strength' => rand(9, 11),
			'quickness' => rand(4, 7),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(4, 8),
			'nuyen' => 0,
			'base_hp' => rand(20, 55),
		);
	}
}
?>
