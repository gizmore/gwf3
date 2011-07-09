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
				return $this->reply('Yeah, i even sell some magic potions and elixirs.');
			
			case 'alchemy':
				return $this->reply('Alchemy is that art of creating potions.');
				
			case 'chemistry':
				$this->reply("You can buy similar things here for {$b}alchemy{$b} and {$b}magic{$b} potions.");
				$player->giveKnowledge('words', 'Magic');
				$player->giveKnowledge('words', 'Alchemy');
				return true;
			
			case 'hello':
				$name = $this->getName();
				return $this->reply("Hello, my name is {$name} and i sell items for {$b}chemistry{$b} and similar stuff.");
				
			default:
				return $this->reply("I don't know anything about $word.");
		}
	}
}
?>