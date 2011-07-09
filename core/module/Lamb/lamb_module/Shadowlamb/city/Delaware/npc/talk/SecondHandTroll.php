<?php
final class Delaware_SecondHandTroll extends SR_TalkingNPC
{
	public function getName() { return 'The Troll'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'blackmarket':
				return $this->reply('Thank you '.$player->getRace().'!');
			
			case 'yes':
			case 'no':
				return $this->reply('Hehe thanks '.$player->getRace().'!');
				
			case 'hello':
			default:
				return $this->reply('Thank you.');
		}
	}
}
?>