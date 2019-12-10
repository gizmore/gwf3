<?php
final class Seattle_Citizen1 extends SR_HireNPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 50.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'amulet' => array('LO_Amulet_of_orcas:1'),
			'weapon' => array('SteelNunchaku', 'Club', 'Stiletto', 'Fists')
			'armor' => 'StuddedVest',
			'legs' => 'ElvenShorts',
			'boots' => 'Sneakers'
		);
	}
	public function getNPCInventory() { return array('SteelNunchaku', 'Club', 'Stiletto', 'Fists'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 4),
			'melee' => rand(2, 3),
			'ninja' => rand(1, 5),
			'quickness' => rand(3, 6),
			'charisma' => rand(3, 6),
			'distance' => rand(0, 2),
			'nuyen' => rand(40, 60),
			'base_hp' => rand(8, 16),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$key = 'Seattle_Citizen_Hire_'.$player->getID();
		
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun': case 'yes':
				$this->reply("I am looking for a job. Would you like to {$b}hire{$b} me?");
				$player->giveKnowledge('words', 'Hire');
				break;

			case 'no':
				$this->reply("Sure, you are not a runner... Though you look like a runner to me.");
				break;
				
			case 'hire':
				
				$ch = $player->get('charisma');
				$re = $player->get('reputation');
				
				if ($player->getParty()->hasHireling()) {
					$this->reply('You already have a hireling. So I say no anway.');
				}
				elseif ( ($this->hasTemp($key))  || (rand(0, 32)>($ch+$re)) )
				{
					$this->reply('You don\'t look very skilled. I better follow my own way.');
					$this->setTemp($key, 1);
				}
				else
				{
					$time = 400 + $ch*40 + $re*20;
					$p = $this->getParty();
					$p->kickUser($this, true);
					$this->onHireC($player, $time);
					$p->popAction(true);
					$player->getParty()->popAction(true);
					$this->reply("Ok, let's go!");
				}
				break;
				
			case 'invite':
				$quest = SR_Quest::getQuest($player, 'Seattle_Barkeeper');
				$quest instanceof Quest_Seattle_Barkeeper;
				$quest->onTryInvite($this, $player);
				break;
				
			case 'temple':
				$quest = SR_Quest::getQuest($player, 'Redmond_Temple');
				$quest instanceof Quest_Redmond_Temple;
				$quest->onMerchandize($this, $player);
				break;
				
			default:
			case 'hello':
				$this->reply("Hello chummer. Are you on a {$b}Shadowrun{$b}?");
				$player->giveKnowledge('words', 'Yes');
				$player->giveKnowledge('words', 'No');
				$player->giveKnowledge('words', 'Shadowrun');
				break;
		}
	}
}
