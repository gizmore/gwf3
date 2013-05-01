<?php
final class Quest_Delaware_MCJohnson3 extends SR_Quest
{
// 	public function getQuestName() { return 'Cops'; }
// 	public function getQuestDescription() { return sprintf("Bring %d/%d CopCaps to Mr. Johnson in the MacLarens pub in Delaware.", $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getNeededAmount() { return 4; }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 2500; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->giveQuesties($player, $npc, 'CopCap', $this->getAmount(), $this->getNeededAmount());
		$this->saveAmount($have);
		
		if ($have >= $this->getNeededAmount())
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply("You did a great job again. Thank you. Very well done.");
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more', array($this->getNeededAmount()-$have)));
// 			return $npc->reply(sprintf('We still need %d more CopCaps.', $this->getNeededAmount()-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I got some difficult job for you now.");
				$npc->reply($this->lang('sr2', array($need)));
// 				$npc->reply("All you need to know is that we need {$need} CopCaps for a client.");
				$npc->reply($this->lang('sr3', array($dp)));
// 				$npc->reply("Your payment would be $dp. Accepted?");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm', array($dp)));
// 				$npc->reply("I will pay you $dp.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply("Great, I will await you back soon.");
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Ok.');
				break;
		}
		return true;
	}
}
?>
