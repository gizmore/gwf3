<?php
final class Delaware_AresMan extends SR_TalkingNPC
{
	public function getName() { return 'The salesman'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		
	}
}
?>