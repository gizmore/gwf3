<?php
final class Chicago_ShrineMonk extends SR_TalkingNPC
{
	public function getName() { return 'The monk'; }

	public function getNPCQuests(SR_Player $player)
	{
		return array(
			'Chicago_ShrineMonksRevenge',
			'Chicago_ShrineMonksEquip',	
		);
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
			case 'seattle': return $this->reply("We were thinking about expanding there, but there was some evil in the air and it isn't good for business.");
			case 'shadowrun': return $this->reply("Thank you for your help.");
			case 'cyberware': return $this->reply("Cyberware is not good for your aura.");
			case 'magic': return $this->reply("The mind is everything. What you think you become.");
			case 'hire': return $this->reply("Sorry, I already have an employer.");
			case 'blackmarket': return $this->reply("I've heard something about Seattle ...");
			case 'bounty': return $this->reply("We can't afford high bounties, but we might give you blessing.");
			case 'alchemy': return $this->reply("We use only simple potions for relaxation.");
			case 'invite': return $this->reply("Thank you, but I have to stay here.");
			case 'renraku': return $this->reply("I heard some terrible things about them.");
			case 'malois': return $this->reply("I haven't heard about him for a long time, he somehow disappeared.");
			case 'bribe': return $this->reply("You can't bribe us, buddha gives us everything we need.");
			case 'yes': return $this->reply("May buddha guide your way.");
			case 'no': return $this->reply("May buddha guide your path.");
			case 'negotiation': return $this->reply("Negotiation is useful skill.");
			case 'hello': return $this->reply("Welcome, how may I help you?");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>
