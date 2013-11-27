<?php
final class Chicago_Monnino extends SR_TalkingNPC
{
	public function getName() { return 'monnino'; }
	
	# No quest? :O # XXX
	public function getNPCQuests(SR_Player $player) { return array(); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === self::onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		switch ($word)
		{
			case 'seattle': return $this->rply($word);
			case 'shadowrun': return $this->rply($word);
			case 'cyberware': return $this->rply($word);
			case 'magic': return $this->rply($word);
			case 'hire': return $this->rply($word);
			case 'blackmarket': return $this->rply($word);
			case 'bounty': return $this->rply($word);
			case 'alchemy': return $this->rply($word);
			case 'invite': return $this->rply($word);
			case 'renraku': return $this->rply($word);
			case 'malois': return $this->rply($word);
			case 'bribe': return $this->rply($word);
			case 'yes': return $this->rply($word);
			case 'no': return $this->rply($word);
			case 'punks': return $this->rply($word);
			case 'donate': return $this->rply($word);
			case 'ninja': return $this->rply($word);
			case 'smithing': return $this->rply($word);
			case 'temple': return $this->rply($word);
			case 'negotiation': return $this->rply($word);
			case 'hello': return $this->rply($word);
			default: return $this->rply('default', array($word));
		}
	}
}
?>