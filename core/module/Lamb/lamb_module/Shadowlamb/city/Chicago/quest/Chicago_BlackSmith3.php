<?php
final class Quest_Chicago_BlackSmith3 extends SR_Quest
{
	public function getRewardXP() { return 20; }
	public function getRewardNuyen() { return 10000; }
	public function getNeededAmount() { return 1; }
	
	public function getQuestDescription() { return $this->lang('descr', array(Shadowlang::displayItemNameS(Forest_Clearing::THESWORD))); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->giveQuesties($player, $npc, Forest_Clearing::THESWORD, 0, 1, true))
		{
			$npc->reply($this->lang('wow'));
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more'));
		}
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				return $npc->reply($this->lang('sr3', array($this->displayRewardNuyen())));
			case 'confirm':
				return $npc->reply($this->lang('confirm'));
			case 'yes':
				return $npc->reply($this->lang('yes'));
			case 'no':
				return $npc->reply($this->lang('no'));
		}
		return false;
	}
}
?>
