<?php
final class Delaware_Alchemist_NPC extends SR_TalkingNPC
{
	public function getName() { return 'Simon'; }
	
	public function getNPCModifiers()
	{
		return array('race'=>'elve');
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'magic':
				return $this->reply('Yeah, I even sell some magic potions and elixirs.');
			
			case 'chemistry':
				$this->reply("You can buy similar things here for chemistry or even {$b}magic{$b} potions.");
				$player->giveKnowledge('words', 'Magic');
				return true;
			
			case 'hello':
				return $this->reply("Hello, my name is ".$this->getName()." and I sell items for {$b}chemistry{$b} and similar stuff.");
				
			case 'gizmore':
			case 'somerandomnick':
				return $this->reply(sprintf('Oh you mean my brother %s in Amerindian.', $word));
				
			default:
				return $this->reply("What do you mean with $word?");
		}
	}
}
?>