<?php
final class Renraku_OfficeWorker extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
// 	public function getName() { return 'The employee'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_GJohnson3');
		$quest instanceof Quest_Seattle_GJohnson3;
		
		switch ($word)
		{
			default:
				if ($quest->givePackage($this, $player))
				{
					return true;
				}
				return $this->rply('default');
//				return $this->reply('How can I help you?');
		}
	}
}
?>
