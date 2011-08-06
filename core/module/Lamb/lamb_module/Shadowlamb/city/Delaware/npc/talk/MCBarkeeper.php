<?php
final class Delaware_MCBarkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The bartender'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			default: return $this->reply('Hello chummer, i am still unimplemented.');
		}
	}
}
?>
