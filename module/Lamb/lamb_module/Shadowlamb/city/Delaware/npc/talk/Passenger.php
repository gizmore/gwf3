<?php
final class Delaware_Passenger extends SR_TalkingNPC
{
	public function getName() { return 'The passenger'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			default:
				return $this->reply('You look no god man. You got any change?');
		}
	}
}
?>