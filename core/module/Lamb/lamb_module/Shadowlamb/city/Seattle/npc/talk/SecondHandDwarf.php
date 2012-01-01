<?php
final class Seattle_SecondHandDwarf extends SR_TalkingNPC
{
	public function getName() { return 'Erwin'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2); # bold
		switch ($word)
		{
			case 'malois': return $this->reply('We are only interested in equipment'); 
			case 'seattle': return $this->reply("You know where you are. Well done");
			case 'shadowrun': return $this->reply("Oh yes, a shadowrunner. Well I have all the equipment you need");
			case 'cyberware': return $this->reply("I am just a humble salesman");
			case 'magic': return $this->reply("It's magic!");
		      //case 'hire': return $this->reply("");
			case 'blackmarket': return $this->reply("No no no. My goods are MUCH better");
		      //case 'bounty': return $this->reply("");
			case 'alchemy': return $this->reply("Maybe I have some stuff. Have a look chummer");
			case 'invite': return $this->reply("I don't have time for that!");
			case 'malois': return $this->reply("I have heard of him. Stay clear of him if I were you chummer");
			case 'yes': return $this->reply("I agree");
			case 'no': return $this->reply("Why not?");
			case 'negotiation': return $this->reply("Maybe at the blackmarket but not here. you get what you pay for");

			case 'hello': return $this->reply("Welcome chummer to my store, leave your conscience at the door, bring your friends - even three or four, if they all have money - maybe more!");
			default:
				return $this->reply("Are you crazy?");
			
		}
	}
}
?>