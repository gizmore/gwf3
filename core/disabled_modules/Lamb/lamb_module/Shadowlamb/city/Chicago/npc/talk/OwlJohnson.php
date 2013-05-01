<?php
final class Chicago_OwlJohnson extends SR_TalkingNPC
{
	public function getName() { return 'Mr. Johnson'; }
	
	public function getNPCQuests(SR_Player $player)
	{
		return array(
			'Chicago_OwlJohnsonRoundtrip',
			'Chicago_OwlJohnsonHourglass',
			'Chicago_OwlJohnsonBackup',
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
			case 'seattle': return $this->reply("I have been to Seattle a lot ... but not lately.");
			case 'shadowrun': return $this->reply("Yo chummer.");
			case 'cyberware': return $this->reply("I don't trust cyberware. You better don't as well.");
			case 'magic': return $this->reply("I don't trust magicians.");
			case 'hire': return $this->reply("Heh ... _YOU_ want to hire _ME_? thehe.");
			case 'blackmarket': return $this->reply("Maybe i have connections, maybe i don't.");
			case 'bounty': return $this->reply("There is a bounty on you?");
			case 'alchemy': return $this->reply("I don't trust alchemists.");
			case 'invite': return $this->reply("I don't party anymore.");
			case 'renraku': return $this->reply("I don't trust them.");
			case 'malois': return $this->reply("You better don't ask stupid questions.");
			case 'bribe': return $this->reply("You cannot bribe me.");
			case 'yes': return $this->reply("Yes");
			case 'no': return $this->reply("No");
			case 'negotiation': return $this->reply("I don't negotiate.");
			case 'hello': return $this->reply("Yo chummer.");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>