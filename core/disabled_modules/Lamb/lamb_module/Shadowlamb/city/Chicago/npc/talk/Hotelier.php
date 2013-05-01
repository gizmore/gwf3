<?php
final class Chicago_Hotelier extends SR_TalkingNPC
{
	public function getName() { return 'The hotelier'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$price = 150;
		switch ($word)
		{
			case 'renraku': return $this->reply('We have not heard anything bad from Renraku lately.');
			case 'shadowrun': return $this->reply('I am not into illegal stuff.');
			case 'cyberware': return $this->reply('I would not implant any metal into my body, if i were you, chummer.');
			case 'magic': return $this->reply('I do not judge people by their race or profession ... nowadays magic is quite normal.');
			case 'hire': return $this->reply('Haha no ... i have to keep to the hotel running.');
			case 'blackmarket': return $this->reply('I am not into illegal things, chumer.');
			case 'bounty': return $this->reply('I am not into illegal things, runner.');
			case 'seattle': return $this->reply('I don\'t like seattle much. It\'s all deprecated and not even scripted.');
			case 'alchemy': return $this->reply('Do not do illegal things in my rooms, chummers!');
			case 'invite': return $this->reply('I am not into parties anymore.');
			case 'malois': return $this->reply('The girl here is asking for that guy ... ya why?');
				
			case 'hello': 
			case 'yes':
			case 'no':
			case 'negotiation':
			
			default:
				return $this->reply("Hello. We offer a room to you for {$price} Nuyen per day and person. We hope you enjoy your stay.");
		}
	}	
}
?>
