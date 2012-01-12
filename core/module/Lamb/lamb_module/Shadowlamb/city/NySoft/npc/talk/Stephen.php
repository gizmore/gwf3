<?php
final class NySoft_Stephen extends SR_TalkingNPC
{
	public function getName() { return 'Stephen'; }

	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("I'm happy I'm out of there. Delaware is way more awesome.");
			case 'shadowrun': return $this->reply("So you are a Runner? Good for you.");
			case 'cyberware': return $this->reply("Cyberware? Its awesome. Just remember that enemy spells hurt you a lot with too much cyberware :(");
			case 'magic': return $this->reply("Magic sucks. Use cyberware :)");
			case 'hire': return $this->reply("Can't hire me. I like my job here, much better than back in Renraku.");
			case 'blackmarket': return $this->reply("Shhh! If my boss Andrew hears us he will fire me!");
			case 'bounty': return $this->reply("There's no bounty on me, go away!");
			case 'alchemy': return $this->reply("Are you from medieval times? There's no such thing as changing stone to gold!");
			case 'invite': return $this->reply("A party? It's not in an elevator, so I won't come.");
			case 'renraku': return $this->reply("Don't remind me of that, have been bad times.");
			case 'malois': return $this->reply("Hmm.. I heard this name before, but i don't remember...");
			case 'bribe': 
				if (count($args) === 0)
				{
					return $this->reply("Please specify an amount to bribe Stephen");
				} else {
					if ($player->hasNuyen($args[1])) {
						return $this->reply("Don't try to fool me, you don't have enough ny");
					} else  {
						$player->pay($args[1]);
						return $this->reply("Thanks, but I don't have anything for you.");
					}
				}
				
			case 'yes': return $this->reply("Yes what? \"Yes sir!\" it is");
			case 'no': return $this->reply("...");
			case 'negotiation': return $this->reply("That won't work on me.");
			case 'hello': return $this->reply("Hello, I'm Stephen.");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>