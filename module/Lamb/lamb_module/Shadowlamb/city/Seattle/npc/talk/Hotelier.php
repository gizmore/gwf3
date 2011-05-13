<?php
final class Seattle_Hotelier extends SR_TalkingNPC
{
	public function onNPCTalk(SR_Player $player, $word)
	{
		$price = 40;
		
		$quest = SR_Quest::getQuest($player, 'Redmond_Johnson_3');

		if ($quest->isInQuest($player))
		{
			$quest->checkQuest($this, $player);
		}
		
		switch ($word)
		{
			case 'renraku': $msg = "Oh, you are here to visit the Renraku building? You better have the permission to do so."; break;
			case 'shadowrun': $msg = "Hmm, when you look for a job, you should visit the local pubs."; break;
			default: $msg = "Hello. We offer a room to you for {$price} Nuyen per day and person. We hope you enjoy your stay."; break;
		}
		$this->reply($msg);
	}
}
?>
