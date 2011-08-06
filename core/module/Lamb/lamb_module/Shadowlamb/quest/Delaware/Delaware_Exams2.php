<?php
final class Quest_Delaware_Exams2 extends SR_Quest
{
	public function getQuestName() { return 'Exams2'; }
	public function getQuestDescription() { return sprintf('Bring %d of %d waterbottles to the gnome in the Delaware_Library.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 40; }
	public function getNeededAmount() { return 6; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'WaterBottle', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Thank you a lot, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('I still need %d waterbottles for my experiments.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Yes, yes, the water is not pure enough here. Please bring me {$need} waterbottles.");
				$npc->reply('Thanks.');
				break;
			case 'confirm':
				$npc->reply("Do you accept the quest?");
				break;
			case 'yes':
				$npc->reply('Thank you chummer.');
				break;
			case 'no':
				$npc->reply('I am not sure.');
				break;
		}
		return true;
	}
}
?>