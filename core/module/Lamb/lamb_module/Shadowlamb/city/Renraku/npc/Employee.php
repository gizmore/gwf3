<?php
final class Renraku_Employee extends SR_TalkingNPC
{
	public function getNPCLevel() { return 2; }
	public function getNPCPlayerName() { return 'Employee'; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.0; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$hire = __CLASS__.'_HIRE';
		$help = __CLASS__.'_HELP';
		$helpyes = __CLASS__.'_HELPYES';
		
		switch ($word)
		{
			case 'magic': return $this->reply('The magic department is in level 3. Use your IDCard3 at the elevator and simply choose floor 3.');
			case 'cyberware': return $this->reply('The cyberware department is in level 2. Use your IDCard2 at the elevator and simply choose floor 2.');
			case 'hire':
				if ($this->hasTemp($hire))
				{
					$this->reply('Nah.');
					return $this->bye();
				}
				$this->setTemp($hire, 1);
				$this->reply('What do you plan?');
				break;
			
			case 'renraku':
				$this->nervousAlert($player);
				break;
				
			case 'yes':
				if ($this->hasTemp($help))
				{
					$this->setTemp($helpyes);
					$this->reply('May I see your ID card please?');
				}
				else
				{
					$this->reply('Yes, what?');
				}
				break;
				
			case 'no':
				if ($this->hasTemp($helpyes))
				{
					$this->nervousAlert($player);
				}
				break;
				
			default:
				if ($this->hasTemp($hire))
				{
					$this->reply('I don\'t know');
				}
				elseif ($this->hasTemp($help))
				{
					$this->reply('See ya\'round, chummer.');
					$this->bye();
				}
				else
				{
					$this->reply('Hey, I don\'t know you ... Can I help?');
					$this->setTemp($help);
				}
				break;
		}
		return true;
	}

	private function nervousAlert(SR_Player $player)
	{
		$party = $player->getParty();
		$party->notice('The employee looks nervous ... ');
		$this->reply('I have to go now.');
		$party->notice('After a few seconds you hear the alert sound.');
		$renraku = Shadowrun4::getCity('Renraku');
		$renraku->setAlert($party, 1200);
		return $this->bye();
	}
}
?>