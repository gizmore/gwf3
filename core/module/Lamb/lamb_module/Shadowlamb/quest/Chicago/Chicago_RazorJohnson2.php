<?php
final class Quest_Chicago_RazorJohnson2 extends SR_Quest
{
	public function getQuestName() { return 'Military'; }
	public function getNeededAmount() { return 8; }
	public function getQuestDescription() { return sprintf('Bring %d/%d MilitaryCircuits to Mr.Johnson in the RazorsEdge, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 4000; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'MilitaryCircuits', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Good job, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Excellent. Here is a compensation for your time.');
			$player->message('Mr. Johnson hands you a letter.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('We could still need %d MilitaryCircuit(s).', $need-$have));
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
				$npc->reply("You know the military drones ... i pay well for their parts.");
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