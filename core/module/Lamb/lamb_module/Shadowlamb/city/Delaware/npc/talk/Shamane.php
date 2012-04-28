<?php
/**
 * @author wannabe7331
 */
final class Delaware_Shamane extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
// 	public function getName() { return 'The magician'; }
	   
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
// 		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': #return $this->reply("Seattle is a nice place, good for calming down, if you don't meet the wrong people.");
// 			case 'bribe': return $this->reply("");
// 			case 'malois': return $this->reply("");
// 			case 'shadowrun': return $this->reply("");
			case 'cyberware': #return $this->reply("Cyberware is bad, only fists and magic defeat the evil!");
			case 'magic': #return $this->reply("Magic is either bad or good, it's just the question how you'll use it. Absolve the #courses, and you will see what I mean.");
			case 'hire': #return $this->reply("I'm too old for that.");
			case 'blackmarket': #return $this->reply("I think you don't need a black market. Strong people don't do things illegally.");
// 			case 'bounty': #return $this->reply("");
			case 'alchemy': #return $this->reply("Alchemy, interesting topic, but magic is more interesting. Learn something!");
			case 'invite': #return $this->reply("I'm too old for parties. Thanks.");
			case 'renraku': #return $this->reply("Be careful.");
			case 'yes': #return $this->reply("Yes? Yes!");
			case 'no': #return $this->reply("No? Many people have problems in saying \"no\", you have to be someone special.");
			case 'negotiation': #return $this->reply("Negotiation? Never.");
			case 'hello': #return $this->reply("Hello my friend!");
				return $this->rply($word);
			default:
				return $this->rply('default');
// 				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>
