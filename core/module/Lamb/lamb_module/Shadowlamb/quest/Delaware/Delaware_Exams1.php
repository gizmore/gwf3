<?php
final class Quest_Delaware_Exams1 extends SR_Quest
{
	public function getQuestName() { return 'Exams'; }
	public function getQuestDescription() { return sprintf('Bring %d of %d empty bottles to the gnome in the Delaware_Library.', $this->getAmount(), $this->getNeededAmount()); }
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
			$npc->reply('Thank you, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('I still need %d bottles for my experiments.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("I am doing \X02alchemic\X02 experiments.");
				$npc->reply("As you are here you can bring me {$need} empty bottles.");
				$player->giveKnowledge('words', 'Alchemy');
				break;
			case 'confirm':
				$npc->reply("Yes i need {$need} empty bottles. Accept the 'quest'?");
				break;
			case 'yes':
				$npc->reply('What?');
				break;
			case 'no':
				$npc->reply('No.');
				break;
		}
		return true;
	}
}
?>