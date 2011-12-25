<?php
final class Quest_Chicago_SaleSmith1 extends SR_Quest
{
	public function getQuestName() { return 'Blades'; }
	public function getNeededAmount() { return 4; }
	public function getQuestDescription() { return sprintf('Bring %d/%d NinjaSwords to the Chicago Blakcksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 0; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'NinjaSword', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Alright chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Excellent. I will from now on break items for free for you!');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('Don\'t ask why, but i need %d more Ninja Sword(s).', $need-$have));
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
				$npc->reply("Chummer i propose you a deal. Bring me %d NinjaSwords and i will #break all items for free for you.");
				break;
			case 'confirm':
				$npc->reply("What do you say?");
				break;
			case 'yes':
				$npc->reply('See you around chummer.');
				break;
			case 'no':
				$npc->reply('Ok');
				break;
		}
		return true;
	}
}
?>