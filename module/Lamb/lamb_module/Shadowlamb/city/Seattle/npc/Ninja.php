<?php
final class Seattle_Ninja extends SR_NPC
{
	public function getNPCLevel() { return 13; }
	public function getNPCPlayerName() { return 'Ninja'; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'NinjaSword',
			'armor' => 'Uwagi',
			'legs' => 'Hakama',
			'boots' => 'ChikaTabi',
			'helmet' => 'Tenugui'
		);
	}
	public function getNPCInventory() { return array('Stimpatch'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(3, 4),
			'distance' => rand(0, 2),
			'melee' => rand(2, 3),
			'ninja' => rand(2, 4),
			'sharpshooter' => rand(1, 2),
			'nuyen' => rand(10, 60),
			'base_hp' => rand(5, 10),
		);
	}
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_BD4');
		if ($quest->isInQuest($player))
		{
			if (rand(1, 3) === 1)
			{
				return array('Tengui');
			}
		}
		return array();
	}
}
?>