<?php
final class PrisonB2_Malois extends SR_HireNPC
{
	public function getName() { return 'Malois'; }
	public function getNPCLevel() { return 10; }
	public function getNPCPlayerName() { return 'Malois'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (!$this->hasParty())
		{
			return $this->letsGO($player);
		}
		
		switch ($word)
		{
			default:
				return $this->reply('CANNOT SEE ME!');
		}
	}
	
	private function letsGO(SR_Player $player)
	{
		$party = $player->getParty();
		if (false === ($malois = SR_NPC::createEnemyNPC(__CLASS__, $party)))
		{
			$player->message('ERROR!');
			return false;
		}
		$party->notice('Malois says: "You made it! Quick! Let\'s go!"');
		$this->getNPCCityClass()->setAlert($party, 9000000);
		return true;
	}
	
	public function getNPCEquipment()
	{
		return array(
				'armor' => 'ConvictVest',
				'legs' => 'ConvictLegs',
				'boots' => 'ConvictBoots',
		);
	}
	
	public function getNPCModifiers()
	{
		return array(
				'race' => 'human',
				'gender' => 'male',
				'pistols' => rand(2, 3),
				'strength' => rand(3, 4),
				'quickness' => rand(3, 4),
				'firearms'  => rand(1, 2),
				'distance' => rand(4, 8),
				'sharpshooter' => rand(1, 2),
				'nuyen' => 0,
				'base_hp' => rand(25, 35),
		);
	}
}
?>