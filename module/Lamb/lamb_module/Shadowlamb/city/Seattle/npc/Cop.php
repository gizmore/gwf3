<?php
final class Seattle_Cop extends SR_TalkingNPC
{
	public function getNPCLevel() { return 7; }
	public function getNPCPlayerName() { return 'PoliceOfficer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 5.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresViper',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'helmet' => 'CopCap',
			'shield' => 'CopShield',
			'boots' => 'CopBoots',
		);
	}
	
	public function getNPCInventory() { return array('Stimpatch','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm','Ammo_9mm'); }
	
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(1, 2),
			'melee' => rand(5, 6),
			'pistols' => rand(5, 6),
			'firearms' => rand(6, 7),
			'quickness' => rand(2, 4),
			'distance' => rand(0, 2),
			'nuyen' => rand(40, 60),
			'base_hp' => rand(8, 16),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			default:
				return $this->reply("If you have nothing to report, please move along sire.");
		}
	}
	
}
?>