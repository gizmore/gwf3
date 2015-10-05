<?php
final class Quest_Seattle_Farmer extends SR_Quest
{
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function getRewardXP() { return 18; }
	public function getRewardNuyen() { return 600; }
	
	public function getNeededAmount() { return 3; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$npc instanceof SR_TalkingNPC;
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$npc->reply($this->lang('solved'));
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more', max(0, $this->getNeededAmount()-$this->getAmount())));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$ny = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				return $npc->reply($this->lang('sr3', array($this->getNeededAmount(), $ny)));
			
			case 'confirm':
				return $npc->reply($this->lang('confirm'));
				
			case 'yes':
				return $npc->reply($this->lang('yes'));
				
			case 'no':
				return $npc->reply($this->lang('no'));
		}
		return true;
	}
}
?>
