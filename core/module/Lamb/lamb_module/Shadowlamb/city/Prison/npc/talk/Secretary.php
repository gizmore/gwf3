<?php
final class Prison_Secretary extends SR_TalkingNPC
{
	const TEMP_ID = 'PSTIDCARD';
	const CONST_ID = 'MALOIS_ID';
	const TEMP_VIS = 'PSTIDVIS';
	
	public function getName() { return 'The secretary'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("We also have prisoners from Seattle, yes.");
			case 'shadowrun': return $this->reply("We also imprison runners, yes.");
			case 'cyberware': return $this->reply("Cyberware is forbidden in this institute.");
			case 'magic': return $this->reply("The magic races are kept in a special cell block.");
			case 'hire': return $this->reply("Hihi, are you kidding?");
			case 'blackmarket': return $this->reply("Illegal stuff is not allowed in prison. Actually the habitats of the prisoners are well kept.");
			case 'bounty': return $this->reply("Imprisoned people killed for bounty is just a rumor.");
			case 'alchemy': return $this->reply("Alchemy is forbidden inside the prison. Some people try to smuggle WatterBottles, but thats easy to detect.");
			case 'invite': return $this->reply("I have no time this weekend.");
			case 'malois':
// 				if ($this)
				
				$player->setTemp(self::TEMP_ID, 1);
				return $this->reply("Oh you want to visit a prisoner? May i see your ID Card then?");
				
			case 'yes':
				if ($player->hasTemp(self::TEMP_ID))
				{
					$player->unsetTemp(self::TEMP_ID);
					return $this->susanChecksYourID($player);
				}
				return $this->reply("Yes what?");
			
			case 'no': return $this->reply("Ok sire, have a nice day.");
			
			case 'negotiation': return $this->reply("Heh ... what do you want to negotiate?");
			
			case 'hello':
			default:
				return $this->reply("My name is Susan, how may i help you?");
			
		}
	}
	
	private function susanChecksYourID(SR_Player $player)
	{
		if ($player->hasConst(self::CONST_ID))
		{
			$player->setTemp(self::TEMP_VIS, 1);
			$player->giveKnowledge('places', 'Prison_VisitorsRoom');
			return $this->reply("Alright Mr. Peltzer, please goto the visitors room, we will call for your brother any minute.");
		}
		else
		{
			return $this->reply("Oh ... only family members may visit imprisoners ... unless you have a {$b}fakeid{$b} ^^ just kidding.");
		}
	}
}
?>