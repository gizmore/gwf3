<?php
final class Delaware_Citizen extends SR_HireNPC
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
			'race' => SR_Player::getRandomRace(),
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
				$quest = SR_Quest::getQuest($player, 'Delaware_Seraphim2');
				if (!$quest->isInQuest($player))
				{
					$this->reply("I am looking for a job. Would you like to {$b}hire{$b} me?");
					$player->giveKnowledge('words', 'Hire');
					return true;
				}
				
				return $this->seraphimQuest($player, $word, $args);

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
				
				if (!$quest->isInQuest($player)) {
					$this->reply('You invite me to a party? Maybe try #join or #say hire.');
					break;
				}
				
				if (!$this->hasTemp($key2)) {
					$this->setTemp($key2, rand(1,4));
				}
				
				switch ($this->getTemp($key2))
				{
					case 1: $this->reply('Yeah, I am already invited. Thanks.'); break;
					case 2: $this->reply('No, I am not interested.'); break;
					case 3: $this->reply('Better get a job, chummer'); break;
					case 4:
						$this->reply('An invitation for a big party? Sure me and my friends are in. Thank you!');
						$quest->onInviteCitizen($this, $player, $this->getParty()->getMemberCount());
						$this->setTemp($key2, 5);
						break;
					case 5:
						$this->reply('See you there!');
						break;
				}
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

	public function seraphimQuest(SR_Player $player, $word, array $args)
	{
		$race = $this->getRace();
		$gender = $this->getGender();
		
		$player->message('You offer the citizen a job as troll in the SecondHand ...');

		// someone said yes already, but you haven't told Seraphim yet to complete the quest
		$quest = SR_Quest::getQuest($player, 'Delaware_Seraphim2');
		if ($quest->isWorkerFound())
		{
			if ($quest->getWorkerName() === $this->getName())
			{
				return $this->reply("I said 'yes' already. Go tell Seraphim, damnit!");
			}
			return $this->reply("You found someone already. Go tell Seraphim, damnit!");
		}
		
		if ($gender === 'female')
		{
			return $this->reply('A job in the SecondHand? No thanks.');
		}
		
		if ( ($race !== 'troll') && ($race !== 'halftroll') )
		{
			return $this->reply('A job in the SecondHand? .. As troll ... Ok wtf? Oo');
		}
		
		switch (rand(1,3))
		{
			case 1:
				return $this->reply('Me? Job? Hahah!');
			case 2:
				return $this->reply(sprintf('%s not looking for job!', $this->getName()));
			case 3:
				return $this->onAcceptJob($player, $word, $args);
		}
	}
	
	public function onAcceptJob(SR_Player $player, $word, array $args)
	{
		$quest = SR_Quest::getQuest($player, 'Delaware_Seraphim2');
		$quest instanceof Quest_Delaware_Seraphim2;
		$quest->setWorkerFound($this->getName());
		return $this->reply(sprintf('Thanks you. %s think about it!', $this->getName()));
	}
}
?>
