<?php
final class Quest_Chicago_RazorJohnson1 extends SR_Quest
{
	public function getQuestName() { return 'TheElectricPart'; }
	public function getNeededAmount() { return 10; }
	public function getQuestDescription() { return sprintf('Bring %d/%d ElectricParts to Mr.Johnson in the RazorsEdge, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 5000; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'ElectricParts', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Good job, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Excellent. Here is a compensation for your time.');
			$player->message('Mr. Johnson hands you an envelope.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('We could still need %d ElectricPart(s).', $need-$have));
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
				$npc->reply("You know the security drones ... i pay well for their parts.");
				break;
			case 'confirm':
				$npc->reply("You know what to do.");
				break;
			case 'yes':
				$npc->reply('See you around chummer.');
				break;
			case 'no':
				$npc->reply('Laters.');
				break;
		}
		return true;
	}
}
?>