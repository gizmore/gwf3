<?php
final class Quest_Delaware_Exams4 extends SR_Quest
{
// 	public function getQuestName() { return 'Exams4'; }
// 	public function getQuestDescription() { return sprintf('Bring an amulet to the gnome in the Delaware_Library.'); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 1500; }
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Amulet', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Yes, that will totally do =)');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$this->onSolve($player);
			$npc->reply($this->lang('thx2'));
// 			$npc->reply("Now. If you just goto my friend in the Seattle library and fetch me a pot of fluid Auris ...");
		}
		else
		{
			$npc->reply($this->lang('more'));
// 			$npc->reply(sprintf('I need an amulet for my experiments. Amulets are still best for protection against magic damage.', $need-$have));
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
// 				$npc->reply("I totally need a simple amulet. Any one will do :)");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("If you bring me some more stuff I will teach you something.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Please.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Why not?');
				break;
		}
		return true;
	}
}
?>
