<?php
final class Delaware_MCBarkeeper extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
// 	public function getName() { return 'The bartender'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Delaware_MCBartender'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}

		switch ($word)
		{
			case 'hello':
				return $this->rply($word);
			default:
				return $this->rply('default');
		}
	}
}
?>
