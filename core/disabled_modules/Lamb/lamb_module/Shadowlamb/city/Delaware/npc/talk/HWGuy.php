<?php
final class Delaware_HWGuy extends SR_TalkingNPC
{
	public function getName() { return 'Chowben'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'ch0wch0w':
				$player->message($this->langNPC('suspicious'));
// 				$player->message('The elve looks suspicous ...');
				return $this->rply('chow');
// 				return $this->reply(' ... Never heard of him!');
			case 'hello':
				return $this->rply('hello', array($this->getName()));
			default:
				return $this->rply('default', array($word));
// 				return $this->reply('Hello my name is Chowben. Welcome to my hardware store and computer workshop.');
		}
	}
}
?>
