<?php
final class Chicago_OwlBarkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	
	public function getNPCQuests(SR_Player $player)
	{
		return array('Chicago_OwlBarkeeper1');
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("Seattle is a poor city ... only idiots!");
			case 'shadowrun': return $this->reply("Indeed!");
			case 'cyberware': return $this->reply("Do i look like a robot?");
			case 'magic': return $this->reply("Do i look like an elve?");
			case 'hire': return $this->reply("I don't want to follow you, geez.");
			case 'blackmarket': return $this->reply("I don't trust the guys at the blackmarket.");
			case 'bounty': return $this->reply("There is a bounty on you?");
			case 'alchemy': return $this->reply("Don\'t confuse bartenders with alchemists, chummer ^^");
			case 'invite': return $this->reply("I have to work next weekend.");
			case 'renraku': return $this->reply("I don't like Renraku much. But i don't hate them either.");
			case 'malois': return $this->reply("Never heard of him.");
			case 'bribe': return $this->reply("You cannot bribe me.");
			case 'yes': return $this->reply("Yes, amuse yourself.");
			case 'no': return $this->reply("Come on, amuse yourself!");
			case 'negotiation': return $this->reply("");
			case 'hello': return $this->reply("Hello chummer! What may it be?");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>