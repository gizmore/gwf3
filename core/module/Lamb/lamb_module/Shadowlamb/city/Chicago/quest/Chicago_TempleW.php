<?php
final class Quest_Chicago_TempleW extends SR_Quest
{
	public function getQuestName() { return 'Diamonds'; }
	public function getRewardNuyen() { return 300; }
	public function getNeededAmount() { return 6; }
	public function getRewardXP() { return 6; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Diamonds to the WhiteTemple in Chicago.', $this->getAmount(), $this->getNeededAmount()); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Diamond', $have_before, $need);
	
		if ($have > $have_before)
		{
			$npc->reply('Thank you very much.');
			$this->saveAmount($have);
		}
	
		if ($have >= $need)
		{
			$npc->reply('Excellent. When you have brought all stones to their temples, the black magician will help you with your magic.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('We could still need %d more Diamond(s).', $need-$have));
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
				$npc->reply("We will help you on your quest, but you have to pay a price. Bring us {$need} Diamonds.");
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