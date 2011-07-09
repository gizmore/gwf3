<?php
final class Delaware_SecondHandDwarf extends SR_TalkingNPC
{
	public function getName() { return 'Seraphim'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_Seraphim1','Delaware_Seraphim2'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		$c = Shadowrun4::SR_SHORTCUT;
		switch ($word)
		{
			case 'negotiation':
				return $this->reply('Of course we can argue about the price a bit... but not too much.');
				
			case 'yes':
				return $this->reply("Yes, please use {$c}view to see what we have in stock.");
			
			case 'no':
				return $this->reply("Please use {$c}view to see what we have in stock.");
				
			case 'hello':
			default:
				return $this->reply('Hello Dear Sire, my name is Donor. Are you looking for something special?');
		}
	}
}
?>