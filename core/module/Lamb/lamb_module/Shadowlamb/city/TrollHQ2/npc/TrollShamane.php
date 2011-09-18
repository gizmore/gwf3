<?php
final class TrollHQ2_TrollShamane extends SR_TalkingNPC
{
	public function getNPCPlayerName() { return 'Marok'; }
	public function getNPCLevel() { return 14; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCQuests(SR_Player $player) { return array(); }
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'strength' => rand(8, 12),
			'quickness' => rand(1, 2),
			'melee' => rand(6, 9),
			'base_hp' => rand(40, 48),
			'distance' => rand(4, 8),
			'nuyen' => rand(100, 200),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'ElvenStaff',
			'armor' => 'WizardRobe',
			'boots' => 'ArmyBoots',
			'helmet' => 'SamuraiMask',
			'shield' => 'LargeShield',
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		$b = chr(2);
		switch ($word)
		{
			default: return $this->reply("What you want, chummer?");
		}		
	}
	
}
?>