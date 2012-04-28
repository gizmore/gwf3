<?php
final class Delaware_Hotelier extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
// 	public function getName() { return 'The hotelier'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$price = 80;
		switch ($word)
		{
			default:
				return $this->rply('default', array($price));
// 				return $this->reply("Hello. We offer a room to you for {$price} Nuyen per day and person. We hope you enjoy your stay.");
		}
	}	
}
?>
