<?php
final class Quest_Chicago_OwlJohnsonHourglass extends SR_Quest
{
	public function getQuestName() { return 'StolenTime'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Hourglasses to Mr.Johnson in the OwlsClub, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 3000; }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Hourglass', $have_before, $need);
		
		if ($have > $have_before)
		{
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Haha, i knew you could do it!');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('Sup chipper?', $need-$have));
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
				$npc->reply("I have a bet running with the local store that we could not steal {$need} hourglasses from his store.");
				$npc->reply("Can you help me to prove him wrong?");
				break;
			case 'confirm':
				$npc->reply("Can you?");
				break;
			case 'yes':
				$npc->reply('Great!');
				break;
			case 'no':
				$npc->reply('Great!');
				break;
		}
		return true;
	}
}
?>