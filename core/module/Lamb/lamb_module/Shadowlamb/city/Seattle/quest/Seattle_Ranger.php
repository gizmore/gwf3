<?php
final class Quest_Seattle_Ranger extends SR_Quest
{
	public function getRewardXP() { return 40; }
	public function getRewardItems() { return 'SuperBow_of_attack:10'; }
	
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$player->message($this->lang('thx1'));
			$npc->reply($this->lang('thx2'));
			$player->message($this->lang('thx3'));
			$npc->reply($this->lang('thx4'));
			$this->onSolve($player);
		}
		else
		{
			$player->message($this->lang('more'));
		}
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply($this->lang('confirm'));
				break;
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				$npc->reply($this->lang('sr3'));
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
