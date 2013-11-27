<?php
final class Seattle_Florist_Lilly extends SR_TalkingNPC
{
	public function getName() { return 'Lillien'; }

	public function getNPCQuests(SR_Player $player) { return array('Seattle_Florist1'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'love':
				$quest = SR_Quest::getQuest($player, 'Seattle_Florist1');
				if ($quest->isDone($player))
				{
					return $quest->checkQuest($this, $player);
				}
			default:
				parent::onNPCTalk($player, $word, $args);
// 				if (Shadowlang::hasLangNPC($this, $player, $word))
// 				{
// 					return $this->rply($word, $args);
// 				}
// 				return $this->rply('default', $args);
		}
	}
}
?>
