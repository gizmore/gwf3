<?php
final class Seattle_TrollDecker extends SR_NPC
{
	public function getNPCLevel() { return 10; }
	public function getNPCPlayerName() { return 'TrollDecker'; }
	public function getNPCMeetPercent(SR_Party $party) { return 70.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Fichetti',
			'armor' => 'LeatherVest',
			'legs' => 'Trousers',
			'boots' => 'LeatherBoots',
		);
	}

	public function getNPCInventory() { return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'troll',
			'gender' => 'male',
			'strength' => rand(5, 9),
			'quickness' => rand(3, 4),
			'distance' => rand(8, 10),
			'pistols' => rand(4, 6),
			'firearms' => rand(4, 6),
			'sharpshooter' => rand(2, 4),
			'nuyen' => rand(60, 220),
			'base_hp' => rand(20, 24),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Johnson1');
		if ($quest->isInQuest($player))
		{
			$quest->increase('sr4qu_amount', 1);
			$player->message(sprintf('Now you killed %d TrollDeckers for Mr.Johnson.', $quest->getAmount()));
		}
		
		if (rand(0,8) === 0) {
			return array('IDCard');
		}
		
		return array();
	}
	
}
?>