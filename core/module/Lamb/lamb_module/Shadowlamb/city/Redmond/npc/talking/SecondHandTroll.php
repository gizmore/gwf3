<?php
final class Redmond_SecondHandTroll extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'blackmarket':
// 				$this->reply('Jerky '.$player->getRace().'!');
// 				break;
			
			case 'yes':
			case 'no':
// 				$this->reply('Stop that '.$player->getRace().'!');
// 				break;
				
				return $this->rply($word, array($player->getRace()));
				
			case 'hello':
			default:
				return $this->rply('hello');
// 				$this->reply('You look for angry? Don`t make trouble! I look for you...');
// 				break;
		}
	}
}
?>