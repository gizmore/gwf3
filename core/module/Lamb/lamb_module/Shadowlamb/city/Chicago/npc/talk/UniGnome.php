<?php
final class Chicago_UniGnome extends SR_TalkingNPC
{
	const TEMP_WORD = 'Seattle_LibGnome_TW';
	
	public function getName() { return 'Yehremia'; }
	public function getNPCQuests(SR_Player $player) { return array('Chicago_Uni1','Chicago_Uni2','Chicago_Uni3','Chicago_Uni4','Chicago_Uni5','Chicago_Uni6'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		$b = chr(2);
		switch ($word)
		{
// 			case 'auris':
// 				return $this->reply('Auris is magic matter. Ask my friend in Seattle about it.');
				
// 			case 'magic':
// 				return $this->reply("Magic is more powerful if you bind it into potions.");
				
// 			case 'alchemy':
// 				return $this->reply("I don't trust on magic. Some good potion can be better than any spell.");
				
// 			case 'invite':
// 				$this->reply("I have no time for parties, I have to study the powers of {$b}alchemy{$b}.");
// 				$player->giveKnowledge('words', 'Alchemy');
// 				return true;
				
// 			case 'cyberware':
// 				return $this->reply('Cyberware will make you a bad magician. I would not recommend to use that kinda equipment. Please stop to interrupt my research now.');
				
// 			case 'redmond':
// 				return $this->reply('Redmond is a slum city. No magic people there. Not of interest to me.');
				
// 			case 'hire':
// 			case 'gizmore':
// 			case 'seattle':
// 			case 'blackmarket':
// 				return $this->reply('Could you please stop asking useless questions? Can\'t you see I am busy?');
			
			default:
				return $this->reply(sprintf('I hate my brother Federico! Everybody confuses us. My name is %s.', $this->getName()));
		}
	}
}
?>