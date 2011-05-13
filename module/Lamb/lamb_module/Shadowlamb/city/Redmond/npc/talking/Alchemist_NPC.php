<?php
final class Redmond_Alchemist_NPC extends SR_TalkingNPC
{
	public function getName() { return 'Carsten'; }
	
	public function getNPCModifiers()
	{
		return array('race'=>'elve');
	}
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'magic':
				$this->reply('Yeah, i even sell some magic potions and elixirs.');
				break;
			
			case 'chemistry':
				$this->reply("You can buy similar things here for chemistry or even {$b}magic{$b} potions.");
				$player->giveKnowledge('words', 'Magic');
				break;
			
			case 'hello':
				$this->reply("Hello, my name is carsten and i sell items for {$b}chemistry{$b} and similar stuff.");
				break;
				
			default:
				$this->reply("What do you mean with $word?");
				break;
		}
	}
}
?>