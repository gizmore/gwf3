<?php
final class Chicago_RazorBarkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("Harr. I been there once. Boring if you ask me chummer");
			case 'shadowrun': return $this->reply("Shh. I be a runner too. We have to look out for each other, right?");
			case 'cyberware': return $this->reply("None of that crap for me. Too many bots running around this place");
			case 'magic': return $this->reply("If used right it might just save your life");
			case 'hire': return $this->reply("Sorry chummer. I have to work.");
			case 'blackmarket': return $this->reply("The only decent reason to visit that stinking city if you ask me");
			case 'bounty': return $this->reply("Not on me. i am clean.");
			case 'alchemy': return $this->reply("I have no idea");
			case 'invite': return $this->reply("The party is here man. Always here.");
			case 'renraku': return $this->reply("Watch your back when it comes to them...");
			case 'malois': return $this->reply("Aye. I know him. Knew him. Where is he these days?");
			case 'bribe': return $this->reply("If you want to give me money go ahead...");
			case 'yes': return $this->reply("No. Is this a word association game?");
			case 'no': return $this->reply("Yes. Is this a word association game?");
			case 'negotiation': return $this->reply("Prices are set chummer. Its hard enough to make a living as it is.");
			case 'hello': return $this->reply("Harr!");
			default:
				return $this->reply("Have a drink.");
		}
	}
}
?>