<?php
final class Quest_Delaware_Exams3 extends SR_Quest
{
// 	public function getQuestName() { return 'Exams3'; }
// 	public function getQuestDescription() { return sprintf('Bring %d of %d ElvenStaff to the gnome in the Delaware_Library.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getRewardXP() { return 1; }
	public function getRewardNuyen() { return 500; }
	public function getNeededAmount() { return 2; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'ElvenStaff', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Wow you are doing a great job. Thank you! :O');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx2'));
// 			$npc->reply("Tell you what. If you can bring me some more stuff I am gonna teach you a magic spell afterwards! :)");
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($need-$have)));
// 			$npc->reply(sprintf('I still need %d ElvenStaff for my experiments.', $need-$have));
		}
		
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I think my friend in Seattle is right. I need elven staffs to cast more powerful spells.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply('Can you bring me one or two, just in case one gets broken?');
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("This would be really awesome. I am gonna pay you {$ny}.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Yes.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('I am not sure.');
				break;
		}
		return true;
	}
}
?>
