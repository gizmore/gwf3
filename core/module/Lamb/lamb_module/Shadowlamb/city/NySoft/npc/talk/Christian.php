<?php
final class NySoft_Christian extends SR_TalkingNPC
{
	public function getName() { return 'Christian'; }
	
	public function getNPCQuests(SR_Player $player)
	{
		return array('NySoft_Priorities');
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
			case 'seattle': return $this->reply("A brother from me wanted to go to Seattle to do arts and music. He is still stuck there.");
			case 'shadowrun': return $this->reply("I don't think doing dirty jobs is the way to go ... but if you have no chance ...");
			case 'cyberware': return $this->reply("Cyberware is too expensive and messes with your mind.");
			case 'magic': return $this->reply("Magic is crazy. I adore those elves and fairies.");
			case 'hire': return $this->reply("I am currently very busy. Are you a headhunter?");
			case 'blackmarket': return $this->reply("The stuff we need does not require a blackmarket. We are a serious company.");
			case 'bounty': return $this->reply("I am not interested in your dirty business.");
			case 'alchemy': return $this->reply("Always wondered what the secret of alchemy is.");
			case 'invite': return $this->reply("I am not into parties this weekend. I have to work.");
			case 'renraku': return $this->reply("I wish i could get a job at Renraku's, but don't tell my boss!");
			case 'malois': return $this->reply("Never heard of him.");
			case 'bribe': return $this->reply("You cannot bribe me. Seriously, i have to work.");
			case 'yes': return $this->reply("Yes, i have to work.");
			case 'no': return $this->reply("Aww no ... what? yes, i have to work!");
			case 'negotiation': return $this->reply("What, no? i have to work.");
			case 'hello': return $this->reply("Hello, i am Christian, what's up dog?");
			default:
				return $this->reply("Damn i cannot get it to work.");
		}
	}
}
?>