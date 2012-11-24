<?php
final class Quest_Delaware_DallasJ3 extends SR_Quest
{
// 	public function getQuestName() { return 'Trolls'; }
// 	public function getQuestDescription() { return sprintf('Kill %d of %d Delaware Trolls and return to Mr.Johnson in the Delaware_Dallas.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 1700; }
	public function getNeededAmount() { return 12; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Well done chummer. Take your reward.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more', array($need-$have)));
// 			return $npc->reply(sprintf('Please kill %d more Trolls.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I still have no real client. However you can kill some Trolls. They are disturbing my business too.");
				$npc->reply($this->lang('sr2', array($this->getNeededAmount(), $this->displayRewardNuyen())));
// 				$npc->reply(sprintf("Kill %d of them and I will pay you %s.", $this->getNeededAmount(), $this->displayRewardNuyen()));
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("Take this job or be unemployed. You have a choice, at least.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Yeah?');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Ok.');
				break;
		}
		return true;
	}
	
	public function onKillTroll(SR_Player $player)
	{
		$this->increaseAmount(1);
		$player->message($this->lang('kill', array($this->getAmount(), $this->getNeededAmount())));
// 		$player->message(sprintf('Now you killed %d of %d trolls for Mr.Johnson.', $quest->getAmount(), $quest->getNeededAmount()));
	}
}
?>
