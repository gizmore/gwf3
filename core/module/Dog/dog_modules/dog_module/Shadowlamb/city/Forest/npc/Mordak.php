<?php
require_once Shadowrun4::getShadowDir().'city/Forest/location/Clearing.php';

final class Forest_Mordak extends SR_NPC
{
	public function getNPCLevel() { return 35; }
	public function getNPCPlayerName() { return 'Mordak'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; }
	
	public function getNPCEquipment()
	{
		return array(
			'armor' => 'DemonVest',
			'helmet' => 'DemonHelmet',
			'boots' => 'DemonBoots',
			'legs' => 'DemonLegs',
			'weapon' => Forest_Clearing::THESWORD,
			'shield' => 'DemonShield',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'darkelve',
			'gender' => 'male',
			'melee' => 8,
			'ninja' => 10,
			'magic' => 12,
			'intelligence' => 8,
			'wisdom' => 10,
			'casting' => 6,
			'alchemy' => 4,
			'spellatk' => 6,
			'spelldef' => 6,
			'strength' => 8,
			'quickness' => 12,
			'distance' => 16,
			'sharpshooter' => 7,
			'nuyen' => 1500,
			'base_hp' => 80,
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$leader = $player->getParty()->getLeader();
		$leader->giveItems(array(SR_Item::createByName(Forest_Clearing::THESWORD)), $this->getName());
		SR_PlayerVar::setVal($leader, Forest_Clearing::SWORDKEY, '2');
		return array();
	}
}
?>
