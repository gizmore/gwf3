<?php
final class TrollHQ_FemaleOrk extends SR_TalkingNPC
{
	public function getNPCLevel() { return 16; }
	public function getNPCPlayerName() { return 'Ork'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 60.00; }
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'ork',
			'gender' => 'female',
			'strength' => rand(2, 3),
			'melee' => rand(3, 4),
			'sharpshooter' => rand(1, 2),
			'quickness' => rand(4, 5),
			'base_hp' => rand(12, 16),
			'distance' => rand(1, 3),
			'nuyen' => rand(20, 40),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('LongSword','BroadSword'),
			'armor' => 'LeatherVest',
			'boots' => 'ArmyBoots',
			'helmet' => 'Cap',
			'legs' => 'Trousers',
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$player->message('The orks grunt.');
		$this->reply("What the ...");
		$ep = $this->getParty();
		$ep->popAction();
		return $player->getParty()->fight($ep, true);
	}
}
?>