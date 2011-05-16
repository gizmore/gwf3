<?php
final class Seattle_BMGuy extends SR_TalkingNPC
{
	public function getName() { return 'Mogrid'; }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		switch ($word)
		{
			default: $msg = '';
		}
		$this->reply($msg);
	}
}
?>