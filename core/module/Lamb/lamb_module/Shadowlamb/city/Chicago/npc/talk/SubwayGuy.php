<?php
/**
 * @author sabretooth
 */
final class Chicago_SubwayGuy extends SR_TalkingNPC
{
	public function getName() { return 'The passenger'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'renraku': return $this->reply("The nightmares. Please don't...");
			case 'shadowrun': return $this->reply("I was once a {$b}shadowrun{$b}ner. Then they got hold of me...");
			case 'cyberware': return $this->reply("I know nothing of this. Beep");
			case 'magic': return $this->reply("The world is full of {$b}magic{$b}");
			case 'hire': return $this->reply("I don't think I dare... Sorry chummer");
			case 'blackmarket': return $this->reply("You need a permission to enter. Ask around");
			case 'bounty': return $this->reply("There is no {$b}bounty{$b} on my head!");
			case 'seattle': return $this->reply("The city is big. It is dangerous here");
			case 'alchemy': return $this->reply("I know nothing of this");
			case 'invite': return $this->reply("No. No I can't show my face");
			case 'malois': return $this->reply("Who?");
			case 'hello': return $this->reply("Hi... Please don't hurt me!");
			case 'yes': return $this->reply("Don't say {$b}yes{$b} to everything. You can get into a lot of trouble");
			case 'no': return $this->reply("I wish I'd have said {$b}no{$b}");
			//case 'negotiation':
			default:
				return $this->reply("Leave me alone.");
		}
	}	
}
?>