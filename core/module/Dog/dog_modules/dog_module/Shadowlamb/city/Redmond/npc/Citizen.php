<?php
final class Redmond_Citizen extends SR_HireNPC
{
	public function getNPCLevel() { return 1; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 40.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => rand('Knife', 'Fists', 'IronPipe', 'BrassKnuckles')
			'armor' => rand('Clothes','LeatherVest', 'ChainVest', 'Lined Duster')
			'legs' => rand('Trousers', 'Shorts', 'ElvenShorts')
			'boots' => rand('Sneakers', 'Shoes', 'Boots')
		);
	}
	public function getNPCInventory('Knife', 'IronPipe', 'BrassKnuckles') { return array('firstaid'); }
	public function getNPCModifiers() {
		return array(
			'race' => rand('human', 'halfelve', 'dwarf', 'halfork')
			'gender' => rand('male', 'female')
			'strength' => rand(2, 4),
			'quickness' => rand(1, 4),
			'distance' => rand(0, 2),
			'nuyen' => rand(10, 20),
			'sharpshooter' => rand(0, 1),
			'melee' => rand(0, 2)
			'ninja' => rand(0,1),
			'biotech' => rand(0,2),
			'base_hp' => rand(4, 8),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$key = 'ASKED_'.$player->getID();
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
				
			return true;
		}
	}
}
