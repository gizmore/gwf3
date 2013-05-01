<?php
final class Redmond_Passenger extends SR_TalkingNPC
{
	public function getName() { return 'The passenger'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'renraku': $msg = 'Renraku has an office in Seattle. You gonna visit it?'; break;
			case 'shadowrun': $msg = 'You are a shadowrunner. Hehe, can`t be, else you wouldnt talk about it.'; break;
			default: $msg = 'Hello. If you are about to leave Redmond be warned; It`s tough in Seattle.'; break;
		}
		$this->reply($msg);
	}
}
?>