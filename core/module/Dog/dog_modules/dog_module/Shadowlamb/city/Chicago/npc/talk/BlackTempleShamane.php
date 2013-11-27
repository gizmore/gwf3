<?php
final class Chicago_BlackTempleShamane extends SR_TalkingNPC
{
	public function getName() { return 'The black wizard'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_TempleB', 'Chicago_BlackMagic'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (self::onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("It will fall. Just like many other great cities.");
			case 'shadowrun': return $this->reply("Hah. I could wipe them out with one flick of my wrist.");
			case 'cyberware': return $this->reply("Do not waste my time.");
			case 'magic': return $this->reply("It is the life force... and the death force. Your path is your choice.");
			case 'hire': return $this->reply("You make me laugh.");
			case 'blackmarket': return $this->reply("They do not deserve to use the word 'black' in their title.");
			case 'bounty': return $this->reply("Money is no issue to me.");
			case 'alchemy': return $this->reply("Those who cannot wield the power try to bottle it. One day it will rise against them...");
			case 'invite': return $this->reply("Do I look like the sort of person who would enjoy a party?");
			case 'renraku': return $this->reply("They are... interesting. I like their style.");
			case 'malois': return $this->reply("No comment.");
			case 'yes': return $this->reply("Yes what?");
			case 'no': return $this->reply("Defiant?  You have guts...");
			case 'negotiation': return $this->reply("When you realise money is nothing, you will learn that bargaining is even less...");
			case 'hello': return $this->reply("You come in here expecting to learn. The true secrets cannot be taught...");
			default:
				return $this->reply("Do not waste my time. Time is most valuable to me.");
		}
	}
}
?>