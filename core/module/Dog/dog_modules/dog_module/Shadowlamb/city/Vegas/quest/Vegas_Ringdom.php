<?php
final class Quest_Vegas_Ringdom extends SR_QuestMultiItem
{
	public function getQuestDataItems(SR_Player $player)
	{
		return array(
			'Ring' => 3,
			'Amulet' => 3,
			'Earring' => 3,
		);
	}
	
	public function getRewardXP() { return 9; }
	public function getRewardNuyen() { return 1800; }
	public function getQuestDescription() { return $this->lang('descr', array($this->getQuestDescriptionStats())); }
	
	public function onQuestMIGiven($npc, SR_Player $player)
	{
		$npc->reply($this->lang('more'));
	}
	
	public function onQuestMISolved($npc, SR_Player $player)
	{
		$npc->reply($this->lang('thx'));
	}
	
	public function onQuestMIMore($npc, SR_Player $player)
	{
		$npc->reply($this->lang('more2'));
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->rply($this->lang('1'));
				$npc->rply($this->lang('2', array($this->getQuestDescriptionStats())));
				break;
			case 'confirm':
				$npc->rply($this->lang('3'));
				break;
			case 'yes':
				$npc->rply($this->lang('4'));
				break;
			case 'no':
				$npc->rply($this->lang('5'));
				break;
		}
		return true;
	}
}
?>
