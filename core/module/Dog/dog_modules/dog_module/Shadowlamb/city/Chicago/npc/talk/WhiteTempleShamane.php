<?php
final class Chicago_WhiteTempleShamane extends SR_TalkingNPC
{
	public function getName() { return 'The white shamane'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_TempleW'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (self::onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("Seattle is part of your past. Do you notice both words start with the same letters?");
			case 'shadowrun': return $this->reply("Doing dirty jobs for dirty people is a dirty business. A good shamane will have a clean mind, and a pure hearth.");
			case 'cyberware': return $this->reply("Electronics control their business. Electronics control their minds. Do you want to be part of an electronic world?");
			case 'magic': return $this->reply("Real magic comes with experience and sharp focus. A powerful magician can form the world beyond his likes.");
			case 'hire': return $this->reply("You cannot hire me for money. And your mission is not of a pure hearth nor eternal importance.");
			case 'blackmarket': return $this->reply("The blackmarket is a place that has to exist. When there is Yin, there is Yan.");
			case 'bounty': return $this->reply("Is there a bounty set on you?");
			case 'alchemy': return $this->reply("Alchemy is the art of putting spells into bottles. This skill is hard to master.");
			case 'invite': return $this->reply("Are you kidding?");
			case 'renraku':
			case 'malois': return $this->reply("The brotherhood is aware of many issues. We will not forget.");
			case 'yes': return $this->reply("Yes is the answer to many questions.");
			case 'no': return $this->reply("No is the answer to many questions.");
			case 'negotiation': return $this->reply("Money is the problem and solution for many things.");
			case 'hello': return $this->reply("Hello traveler. The temple of seattle offers paid courses to train your magic skills. Also feel free to visit our store.");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>