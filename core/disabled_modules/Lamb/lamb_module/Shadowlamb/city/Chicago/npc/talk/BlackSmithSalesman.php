<?php
final class Chicago_BlackSmithSalesman extends SR_TalkingNPC
{
	public function getName() { return 'The salesman'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_SaleSmith1'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("There are smiths in many cities, but ours is the best.");
			case 'shadowrun': return $this->reply("No, no! I am a salesman!");
			case 'cyberware': return $this->reply("Maybe one day the smith will look into implanting it. For now, leave it to the doctor, chummer.");
			case 'magic': return $this->reply("Runes can be broken away from statted items. See the smith!");
			case 'hire': return $this->reply("Why would you want to hire a salesman? Are you shy?");
			case 'blackmarket': return $this->reply("Many items can be bought from there. Watch out for the quality though!");
			case 'bounty': return $this->reply("I have no idea.");
			case 'alchemy': return $this->reply("Fascinating, you think?");
			case 'invite': return $this->reply("No, no. He has had too much already.");
			case 'renraku': return $this->reply("I know nothing of them.");
			case 'malois': return $this->reply("Yeah... I know him.");
			case 'bribe': return $this->reply("For what chummer?");
			case 'yes': return $this->reply("Finally. Someone who agrees with me. Okay smithy... Stop drinking!");
			case 'no': return $this->reply("You hear that smithy? He said no more booze!");
			case 'negotiation': return $this->reply("Maybe a little.");
			case 'hello': return $this->reply("Welcome! Better talk to me... The smith is a bit... busy.");
			default:
				return $this->reply("The smith is always drunk, but he does a great job!");
		}
	}
}
?>