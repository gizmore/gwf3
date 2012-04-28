<?php
final class Delaware_DBarkeeper extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
// 	public function getName() { return 'The barkeeper'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_DBarkeeper'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		switch ($word)
		{
			default:
				return $this->rply('default');
		}
		
	}
}
?>
