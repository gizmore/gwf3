<?php
final class Seattle_Killer extends SR_NPC
{
	public function getNPCLevel() { return 11; }
	public function getNPCPlayerName() { return 'Killer'; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'RugerWarhawk',
			'armor' => 'ChainVest',
			'legs' => 'ChainLegs',
			'boots' => 'ChainBoots',
			'shield' => 'SmallShield',
		);
	}

	public function getNPCInventory() { return array('Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Ammo_11mm', 'Knife'); }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => '4',
			'strength' => rand(1, 3),
			'quickness' => rand(2, 4),
			'distance' => rand(8, 12),
			'pistols' => rand(1, 3),
			'firearms' => rand(1, 3),
			'sharpshooter' => rand(1, 2),
			'nuyen' => rand(50, 100),
			'base_hp' => rand(4, 8),
		);
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_GJohnson1');
		if ($quest->isInQuest($player))
		{
			$quest->increase('sr4qu_amount', 1);
			$player->message(sprintf('Now you killed %d Killers for Mr.Johnson.', $quest->getAmount()));
		}
		return array();
	}
}
?>