<?php
final class Quest_Troll_SourFaced extends SR_QuestMultiItem
{
	public function getQuestName() { return $this->lang('title'); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getQuestDescriptionStats())); }
	
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 200; }
	
	public function getQuestDataItems(SR_Player $player)
	{
		return array('SourMilk' => 5);
	}
	
	public function onQuestMIGiven($npc, SR_Player $player)
	{
		$npc instanceof SR_TalkingNPC;
	}
	
	public function onQuestMIMore($npc, SR_Player $player)
	{
		$npc instanceof SR_TalkingNPC;
		$npc->reply($this->lang('more', array($this->getQuestDescriptionStats())));
	}
	
	public function onQuestMISolved($npc, SR_Player $player)
	{
		$npc instanceof SR_TalkingNPC;
		$npc->reply($this->lang('thx'));
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2', array($this->getQuestDescriptionStats())));
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
				break;
			case 'no':
				$npc->reply($this->lang('no'));
				break;
		}
		return true;
	}
}
?>
