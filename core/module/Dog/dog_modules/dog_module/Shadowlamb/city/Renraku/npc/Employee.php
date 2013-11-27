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
			case 'magic': #return $this->reply('The magic department is in level 3. Use your IDCard3 at the elevator and simply choose floor 3.');
			case 'cyberware': #return $this->reply('The cyberware department is in level 2. Use your IDCard2 at the elevator and simply choose floor 2.');
				return $this->rply($word);
				
			case 'hire':
				if ($this->hasTemp($hire))
				{
					$this->rply('nah');
// 					$this->reply('Nah.');
					return $this->bye();
				}
				$this->setTemp($hire, 1);
				return $this->rply('plan');
// 				$this->reply('What do you plan?');
// 				break;
			
			case 'renraku':
				return $this->nervousAlert($player);
				
			case 'yes':
				if ($this->hasTemp($help))
				{
					$this->setTemp($helpyes);
					return $this->rply('card');
// 					$this->reply('May I see your ID card please?');
				}
				else
				{
					return $this->rply('yes_what');
// 					$this->reply('Yes, what?');
				}
// 				break;
				
			case 'no':
				if ($this->hasTemp($helpyes))
				{
					return $this->nervousAlert($player);
				}
				return $this->rply('no');
// 				break;
				
			default:
				if ($this->hasTemp($hire))
				{
					return $this->rply('dunno');
// 					$this->reply('I don\'t know');
				}
				elseif ($this->hasTemp($help))
				{
					$this->rply('laters');
// 					$this->reply('See ya\'round, chummer.');
					return $this->bye();
				}
				else
				{
					$this->setTemp($help);
					return $this->rply('helpya');
// 					$this->reply('Hey, I don\'t know you ... Can I help?');
				}
// 				break;
		}
// 		return true;
	}

	private function nervousAlert(SR_Player $player)
	{
		$party = $player->getParty();
		$party->notice($this->langNPC('nervous'));
// 		$party->notice('The employee looks nervous ... ');
		$this->rply('bye');
// 		$this->reply('I have to go now.');
		$party->notice($this->langNPC('alert'));
// 		$party->notice('After a few seconds you hear the alert sound.');
		$renraku = Shadowrun4::getCity('Renraku');
		$renraku->setAlert($party, 1200);
		return $this->bye();
	}
}
?>