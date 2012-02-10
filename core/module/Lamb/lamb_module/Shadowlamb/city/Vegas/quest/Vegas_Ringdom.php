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
	public function getQuestName() { return 'Ringdom'; }
	

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->rply('1');
				$npc->rply('2');
				break;
			case 'confirm':
				$npc->rply('3');
				break;
			case 'yes':
				$npc->rply('4');
				break;
			case 'no':
				$npc->rply('5');
				break;
				
		}
	}
}
?>