<?php
final class Quest_Delaware_Exams1 extends SR_Quest
{
// 	public function getQuestName() { return 'Exams'; }
// 	public function getQuestDescription() { return sprintf('Bring %d of %d empty bottles to the gnome in the Delaware_Library.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 20; }
	public function getNeededAmount() { return 8; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'EmptyBottle', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Thank you, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($need-$have)));
// 			$npc->reply(sprintf('I still need %d bottles for my experiments.', $need-$have));
		}
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I am doing \X02alchemic\X02 experiments.");
				$npc->reply($this->lang('sr2', array($need)));
// 				$npc->reply("As you are here you can bring me {$need} empty bottles.");
				$player->giveKnowledge('words', 'Alchemy');
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm', array($need)));
// 				$npc->reply("Yes I need {$need} empty bottles. Accept the 'quest'?");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('What?');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Meh');
				break;
		}
		return true;
	}
}
?>
