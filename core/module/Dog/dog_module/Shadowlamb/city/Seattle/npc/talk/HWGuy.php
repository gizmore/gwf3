<?php
final class Seattle_HWGuy extends SR_TalkingNPC
{
	public function getName() { return 'Iben'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			default:
				return $this->rply('default');
				#$this->reply('Hello my name is Iben. Welcome to my hardware store and computer workshop.');
		}
	}
}
?>