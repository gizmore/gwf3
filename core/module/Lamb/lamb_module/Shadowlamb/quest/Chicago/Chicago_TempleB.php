<?php
final class Quest_Chicago_TempleB extends SR_Quest
{
	public function getQuestName() { return 'Hematites'; }
	public function getRewardNuyen() { return 300; }
	public function getNeededAmount() { return 3; }
	public function getRewardXP() { return 6; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Hematites to the BlackTemple in Chicago.', $this->getAmount(), $this->getNeededAmount()); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Hematite', $have_before, $need);
	
		if ($have > $have_before)
		{
			$npc->reply('Thank you very much.');
			$this->saveAmount($have);
		}
	
		if ($have >= $need)
		{
			$npc->reply('Excellent. When you have brought all stones to their temples, i will help you with your magic knowledge.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('We could still need %d Hematite(s).', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
	
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("We will help you on your quest, but you have to pay a price. Bring us %d Hematite.");
				break;
			case 'confirm':
				$npc->reply("One hand washes the other.");
				break;
			case 'yes':
				$npc->reply('Good luck chummer.');
				break;
			case 'no':
				$npc->reply('See ya, chummer.');
				break;
		}
		return true;
	}
	
}
?>