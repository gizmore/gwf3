<?php
final class Seattle_Alchemist_NPC extends SR_TalkingNPC
{
	public function getName() { return 'Theodore'; }
	
	public function getNPCModifiers()
	{
		return array('race'=>'human');
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'magic':
				return $this->rply($word);
// 				return $this->reply('Yeah, I even sell some magic potions and elixirs.');
			
			case 'alchemy':
				return $this->rply($word);
// 				return $this->reply('Alchemy is that art of creating potions.');
				
			case 'chemistry':
				$this->rply($word);
// 				$this->reply("You can buy similar things here for {$b}alchemy{$b} and {$b}magic{$b} potions.");
				$player->giveKnowledge('words', 'Magic');
				$player->giveKnowledge('words', 'Alchemy');
				return true;
			
			case 'hello':
				$name = $this->getName();
				return $this->rply($word, array($name));
// 				return $this->reply("Hello, my name is {$name} and I sell items for {$b}chemistry{$b} and similar stuff.");
				
			default:
				return $this->rply('default', array($word));
// 				return $this->reply("I don't know anything about $word.");
		}
	}
}
?>