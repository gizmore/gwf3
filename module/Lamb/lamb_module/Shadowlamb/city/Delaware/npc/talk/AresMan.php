<?php
final class Delaware_AresMan extends SR_TalkingNPC
{
	public function getName() { return 'The salesman'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_Ares_I'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		switch ($word)
		{
			default:
				return $this->reply('Come in, come in and upgrade your equipment.');
		}
		
	}
}
?>