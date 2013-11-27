<?php
final class Vegas_Citizen extends SR_HireNPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 80.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('AresViper'),
			'armor' => array('LeatherVest','StuddedVest', 'KevlarVest'),
			'legs' => array('Trousers', 'StuddedLegs', 'KevlarLegs'),
			'helmet' => array('Cap'),
			'boots' => array('Boots','ArmyBoots', 'KevlarBoots'),
		);
	}
	public function getNPCInventory() { return array('60xAmmo_9mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => SR_Player::getRandomRace(),
			'gender' => SR_Player::getRandomGender(),
			'strength' => rand(6, 8),
			'melee' => rand(4, 6),
			'firearms' => rand(5, 7),
			'pistols' => rand(5, 8),
			'sharpshooter' => rand(6, 8),
			'quickness' => rand(2, 4),
			'distance' => rand(0, 2),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(10, 18),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$key = 'Seattle_Citizen_Hire_'.$player->getID();
		$key2 = 'Seattle_Citizen_Invite_'.$player->getID();
		
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun':
				
				if ($this->getGender() === 'male')
				{
					$this->rply('job_male');
					$player->giveKnowledge('words', 'Hire');
				}
				else
				{
					$this->rply('job_female');
				}
				return true;

			case 'no':
				
				return $this->rply('no_'.$this->getGender());
				
			case 'hire':
				
				if ($this->getGender() === 'female')
				{
					return $this->rply('hire_female');
				}
				
				$ch = $player->get('charisma');
				$re = $player->get('reputation');
				
				if ($player->getParty()->hasHireling())
				{
					$this->rply('two_hirelings');
				}
				elseif ( ($this->hasTemp($key))  || (rand(0, 32)>($ch+$re)) )
				{
					$this->rply('not_skilled');
					$this->setTemp($key, 1);
				}
				else
				{
					$this->rply('lets_go');
					$time = 400 + $ch*40 + $re*20;
					$p = $this->getParty();
					$p->kickUser($this, true);
					$this->onHireC($player, $time);
					$p->popAction(true);
					$player->getParty()->popAction(true);
				}
				return true;
				
			case 'invite':
				$quest = SR_Quest::getQuest($player, 'Vegas_Voices');
				$quest instanceof Quest_Vegas_Voices;
				$quest->onTryInvite($this, $player);
				break;
				
			default:
			case 'hello':
				$this->rply('hello'.$this->getGender());
				$player->giveKnowledge('words', 'Yes');
				$player->giveKnowledge('words', 'No');
				$player->giveKnowledge('words', 'Shadowrun');
				break;
		}
		return true;
	}
}
?>
