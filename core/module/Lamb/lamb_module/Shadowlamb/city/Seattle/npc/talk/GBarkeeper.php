<?php
final class Seattle_GBarkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			default:
				$this->reply('Welcome chummer. How are things?');
		}
	}
}
?>