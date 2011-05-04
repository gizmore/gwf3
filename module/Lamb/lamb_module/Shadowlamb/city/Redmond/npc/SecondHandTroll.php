<?php
final class Redmond_SecondHandTroll extends SR_TalkingNPC
{
	public function getName() { return 'The Troll'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		switch ($word)
		{
			case 'blackmarket':
				$this->reply('Jerky '.$player->getRace().'!');
				break;
			
			case 'yes':
			case 'no':
				$this->reply('Stop that '.$player->getRace().'!');
				break;
				
			case 'hello':
			default:
				$this->reply('You look for angry? Don`t make trouble! I look for you...');
				break;
		}
	}
}
?>