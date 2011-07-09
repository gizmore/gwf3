<?php
final class Delaware_HWGuy extends SR_TalkingNPC
{
	public function getName() { return 'Chowben'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'ch0wch0w':
				$player->message('The elve looks suspicous ...');
				return $this->reply(' ... Never heard of him!');
				
			default:
				return $this->reply('Hello my name is Chowben. Welcome to my hardware store and computer workshop.');
		}
	}
}
?>