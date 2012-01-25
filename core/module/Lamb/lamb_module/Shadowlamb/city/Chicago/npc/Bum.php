<?php
final class Chicago_Bum extends SR_HireNPC
{
	public function getNPCLevel() { return 5; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 45.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Knife',
			'armor' => 'Clothes',
			'legs' => 'Trousers',
			'boots' => 'Shoes',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(1, 3),
			'quickness' => rand(2, 3),
			'distance' => rand(8, 12),
			'nuyen' => rand(5, 10),
			'sharpshooter' => rand(1,2),
			'base_hp' => rand(12, 18),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			default:
				return $this->reply("What do you say?");
		}
	}
}
?>