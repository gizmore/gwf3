<?php
final class Redmond_SecondHandDwarf extends SR_TalkingNPC
{
	public function getName() { return 'Donor'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		switch ($word)
		{
			case 'negotiation':
				$this->reply('Of course we can argue about the price a bit... but not too much.');
				break;
				
			case 'yes':
				$this->reply("Yes, please use {$c}view to see what we have in stock.");
				break;
			
			case 'no':
				$this->reply("Please use {$c}view to see what we have in stock.");
				break;
				
			case 'hello':
			default:
				$this->reply('Hello Dear Sire, my name is Donor. Are you looking for something special?');
				break;
		}
	}
}
?>