<?php
final class Quest_Chicago_OwlBarkeeper1 extends SR_Quest
{
	public function getQuestName() { return 'TheOriginal'; }
	public function getNeededAmount() { return 30; }
	public function getQuestDescription() { return sprintf('Bring %d/%d cans of Coke to the Barkeeper in the OwlsClub, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 4000; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Coke', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Thanks chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Great ... here is your money chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('I still want %d cans of coke.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dn = $this->displayRewardNuyen();
		$dpb = Shadowfunc::displayNuyen($ny/$need);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Oh intersting ... well i could need {$need} cans of Coke.... the original ... they are hard to get.");
				$npc->reply("I am going to pay {$dn}, that will be {$dpb} per bottle ... you think you can get them?");
				break;
			case 'confirm':
				$npc->reply("I have no other job... accept this one?");
				break;
			case 'yes':
				$npc->reply('Thank you very much.');
				break;
			case 'no':
				$npc->reply('kk chummer.');
				break;
		}
		return true;
	}
}
?>