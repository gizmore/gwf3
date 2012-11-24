<?php
final class Quest_Redmond_OrkRage extends SR_Quest
{
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function getNeededAmount() { return 12; }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 600; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$npc->reply($this->lang('thx'));
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($this->getAmount(), $this->getNeededAmount())));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				$npc->reply($this->lang('sr3', array($this->getNeededAmount())));
				return $npc->reply($this->lang('sr4'));
			case 'confirm':
				return $npc->reply($this->lang('confirm', array($this->displayRewardNuyen())));
			case 'yes':
				return $npc->reply($this->lang('yes'));
			case 'no':
				return $npc->reply($this->lang('no'));
		}
	}
	
	public function onKilled(SR_Player $player)
	{
		$this->increaseAmount(1);
		return $player->message($this->lang('kill', array($this->getAmount(), $this->getNeededAmount())));
	}
}
?>
