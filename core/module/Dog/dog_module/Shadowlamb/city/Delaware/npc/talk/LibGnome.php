<?php
final class Delaware_LibGnome extends SR_TalkingNPC
{
	const TEMP_WORD = 'Seattle_LibGnome_TW';
	
	public function getName() { return 'Federico'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_Exams1', 'Delaware_Exams2', 'Delaware_Exams3', 'Delaware_Exams4', 'Delaware_Exams5'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
// 		$b = chr(2);
		switch ($word)
		{
			case 'auris':
// 				return $this->reply('Auris is magic matter. Ask my friend in Seattle about it.');
				
			case 'magic':
// 				return $this->reply("Magic is more powerful if you bind it into potions.");
				
			case 'alchemy':
// 				return $this->reply("I don't trust on magic. Some good potion can be better than any spell.");
				
			case 'cyberware':
// 				return $this->reply('Cyberware will make you a bad magician. I would not recommend to use that kinda equipment. Please stop to interrupt my research now.');
				
			case 'redmond':
// 				return $this->reply('Redmond is a slum city. No magic people there. Not of interest to me.');

				return $this->rply($word);
				
			case 'invite':
				$this->rply('invite');
// 				$this->reply("I have no time for parties, I have to study the powers of {$b}alchemy{$b}.");
				$player->giveKnowledge('words', 'Alchemy');
				return true;
				
				
				
			case 'hire':
			case 'gizmore':
			case 'seattle':
			case 'blackmarket':
				return $this->rply('useless');
// 				return $this->reply('Could you please stop asking useless questions? Can\'t you see I am busy?');
			
			default:
				return $this->rply('default', array($this->getName()));
// 				return $this->reply(sprintf('Hello chummer. My name is %s. As you can see I am busy. Also be quiet here!', $this->getName()));
		}
	}
}
?>
