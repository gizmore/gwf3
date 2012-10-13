<?php
final class NySoft_Andrew extends SR_TalkingNPC
{
	public function getName() { return 'Mr.Northwood'; }

	public function getNPCQuests(SR_Player $player)
	{
		return array(
			'NySoft_Andrew1',
			'NySoft_Andrew2',
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
			case 'seattle': return $this->reply($word);
			case 'shadowrun': return $this->reply($word);
			case 'cyberware': return $this->reply($word);
			case 'magic': return $this->reply($word);
			case 'hire': return $this->reply($word);
			case 'blackmarket': return $this->reply($word);
			case 'bounty': return $this->reply($word);
			case 'alchemy': return $this->reply($word);
			case 'invite': return $this->reply($word);
			case 'renraku': return $this->reply($word);
			case 'malois': return $this->reply($word);
			case 'bribe': return $this->reply($word);
			case 'yes': return $this->reply($word);
			case 'no': return $this->reply($word);
			case 'punks': return $this->reply($word);
			case 'donate': return $this->reply($word);
			case 'ninja': return $this->reply($word);
			case 'smithing': return $this->reply($word);
			case 'temple': return $this->reply($word);
			case 'negotiation': return $this->reply($word);
			case 'hello': return $this->reply($word);
			default: return $this->reply('default', array($word));
		}
	}
}
?>