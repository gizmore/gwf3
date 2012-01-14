<?php
final class Chicago_GrayTempleShamane extends SR_TalkingNPC
{
	public function getName() { return 'The gray magician'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_TempleG'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (self::onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("I have been there. There are many things for both the good and evil there. A balanced city.");
			case 'shadowrun': return $this->reply("Some of them do not yet know their place. There is good and bad in all of us.");
			case 'cyberware': return $this->reply("It will probably harm you in the long run, but it is your choice.");
			case 'magic': return $this->reply("Whether good or bad, it is what fuels the fire. Learn the secrets.");
			case 'hire': return $this->reply("No thank you.");
			case 'blackmarket': return $this->reply("The bad side of you would do well to buy there.");
			case 'bounty': return $this->reply("Only if the price is right...");
			case 'alchemy': return $this->reply("Can one bottle magic? I am not sure.");
			case 'invite': return $this->reply("No thank you.");
			case 'renraku': return $this->reply("I do not know much about them. They are a software company? Or a drycleaners?");
			case 'malois': return $this->reply("He is another who does not yet know his own path...");
			case 'yes': return $this->reply("Very decisive!");
			case 'no': return $this->reply("Very decisive!");
			case 'negotiation': return $this->reply("The weak-minded may fall for that, but not here.");
			case 'hello': return $this->reply("Greetings of the day... and night!");
			default:
				return $this->reply("Black or white, they are all the same. Good and bad... all an illusion.");
		}
	}
}
?>