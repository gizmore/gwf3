<?php
require_once 'core/module/Lamb/lamb_module/Shadowlamb/city/Forest/location/Clearing.php';

final class Forest_Skeleton extends SR_NPC
{
	public function getNPCLevel() { return 21; }
	public function getNPCPlayerName() { return 'Skeleton'; }
	public function getNPCMeetPercent(SR_Party $party) { return 30.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'LongSword',
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
			'melee' => rand(8, 10),
			'ninja' => rand(5, 7),
			'strength' => rand(8, 10),
			'quickness' => rand(5, 7),
			'distance' => rand(4, 8),
			'sharpshooter' => rand(5, 12),
			'nuyen' => 0,
			'base_hp' => rand(30, 50),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		# Increase some temp counter
		$leader = $player->getParty()->getLeader();
		$kills = SR_PlayerVar::getVal($player, Forest_Clearing::SKELSKEY, '0');
		$kills++;
		SR_PlayerVar::setVal($player, Forest_Clearing::SKELSKEY, $kills);
		if ($kills >= Forest_Clearing::getNumSkeletons($leader))
		{
			SR_PlayerVar::setVal($player, Forest_Clearing::SWORDKEY, '1');
		}
		
		# A bone \o/
		return array('Bone');
	}
}
?>
