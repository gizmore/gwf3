<?php
final class Quest_Vegas_HiJack extends SR_QuestMultiItem
{
	public function getQuestDataItems(SR_Player $player)
	{
		return array(
			'Cigar' => 30,
		);
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->rply($this->lang('1'));
				$npc->rply($this->lang('2', $this->getQuestDescriptionStats()));
				$npc->rply($this->lang('3'));
				break;
			case 'confirm':
				$npc->rply($this->lang('4'));
				break;
			case 'yes':
				$npc->rply($this->lang('5'));
				break;
			case 'no':
				$npc->rply($this->lang('6'));
				break;
		}
		return true;
	}
	
	
}
?>
