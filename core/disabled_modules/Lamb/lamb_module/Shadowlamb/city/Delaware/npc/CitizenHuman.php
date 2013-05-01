<?php
final class Delaware_CitizenHuman extends SR_HireNPC
{
	public function getNPCLevel() { return 6; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 80.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => array('LongSword','Knife','BroadSword'),
			'armor' => array('LeatherVest','StuddedVest'),
			'legs' => array('Trousers', 'StuddedLegs'),
			'helmet' => array('Cap'),
			'boots' => array('Boots','ArmyBoots'),
		);
	}
	public function getNPCInventory() { return array('Cake'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => SR_Player::getRandomGender(),
			'strength' => rand(2, 4),
			'melee' => rand(4, 6),
			'sharpshooter' => rand(2, 4),
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
			case 'no':
				return $this->reply("Yo chummer, you're on a run?");
				
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
				
			default:
			case 'hello':
				$this->reply("Hello chummer. Are you on a {$b}Shadowrun{$b}?");
				$player->giveKnowledge('words', 'Yes');
				$player->giveKnowledge('words', 'No');
				$player->giveKnowledge('words', 'Shadowrun');
				break;
		}
		return true;
	}
}
?>
