<?php
final class Chicago_BlackSmithSmith extends SR_TalkingNPC
{
	public function getName() { return 'The blacksmith'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_BlackSmith1'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("Seeeeeeeeeeattle! Seee the seaaaa.");
			case 'shadowrun': return $this->reply("shadow... shadow...");
			case 'cyberware': return $this->reply("Heh. Robots are no good chummer.");
			case 'magic': return $this->reply("Maaaagicccc. It is magical and shiny.");
			case 'hire': return $this->reply("I think chummer. I be a bit drunk. I work better that way.");
			case 'blackmarket': return $this->reply("I heard there is one *hic*");
			case 'bounty': return $this->reply("Money makes the world go round.");
			case 'alchemy': return $this->reply("Give me a sword instead. Did I tell you I was drunk? Hah!");
			case 'invite': return $this->reply("Oh yes a party. I love parties. No thank you.");
			case 'renraku': return $this->reply("ren... ren?");
			case 'malois': return $this->reply("I know malois but shhh. It is a secret.");
			case 'bribe': return $this->reply("Give me moneyyyy.");
			case 'yes': return $this->reply("Yes! Grab a beer. Grab a sword. Lets get to work!");
			case 'no': return $this->reply("You make me sad. Pass me a drink.");
			case 'negotiation': return $this->reply("Neg... I cannot even say it chummer. Hahaha!");
			case 'hello': return $this->reply("Hi! Pass me my beer!");
			default:
				return $this->reply("and that is the point when I decided to steal his parrot!");
		}
	}
}
?>