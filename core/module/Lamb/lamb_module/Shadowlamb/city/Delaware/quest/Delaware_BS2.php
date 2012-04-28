<?php
final class Quest_Delaware_BS2 extends SR_Quest
{
// 	public function getQuestName() { return 'Pikey'; }
// 	public function getQuestDescription() { return sprintf('Bring %d/%d Pike to the Delaware Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function getNeededAmount() { return 2; }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 900; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have_after = $this->giveQuesties($player, $npc, 'Pike', $have_before, $need);
		$this->saveAmount($have_after);
		if ($have_after >= $need)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Thank you very much, chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more', array($need-$have_after)));
// 			return $npc->reply(sprintf("Please bring me %d more Pikes. Thank you.", $need-$have_after));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Still looking for a job?");
				$npc->reply($this->lang('sr2', array($need, $this->displayRewardNuyen())));
// 				$npc->reply(sprintf("Hmm ... If you could bring me %d Pikes I would pay %s. What do you think?", $need, $this->displayRewardNuyen()));
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("Do you accept the quest?");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Alright, great :)');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
				$npc->reply('Oh, ok.');
				break;
		}
		return true;
	}
	
}
?>