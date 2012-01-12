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
			case 'seattle': return $this->reply("");
			case 'shadowrun': return $this->reply("");
			case 'cyberware': return $this->reply("");
			case 'magic': return $this->reply("");
			case 'hire': return $this->reply("");
			case 'blackmarket': return $this->reply("");
			case 'bounty': return $this->reply("");
			case 'alchemy': return $this->reply("");
			case 'invite': return $this->reply("");
			case 'renraku': return $this->reply("");
			case 'malois': return $this->reply("");
			case 'bribe': return $this->reply("");
			case 'yes': return $this->reply("");
			case 'no': return $this->reply("");
			case 'negotiation': return $this->reply("");
			case 'hello': return $this->reply("");
			default:
				return $this->reply("I do not know anything about $word.");
		}
	}
}
?>