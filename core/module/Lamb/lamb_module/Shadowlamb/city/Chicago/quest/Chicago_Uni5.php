<?php
final class Quest_Chicago_Uni5 extends SR_Quest
{
	public function getQuestName() { return 'JuniorBachelor'; }
	public function getNeededAmount() { return 12; }
	public function getQuestDescription() { return sprintf('Bring %d/%d bacon to the Chicago University Gnome', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 50; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Bacon', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('Thanks chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Here is your money chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('Can you bring %d more bacon?', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
// 		$ny = $this->getRewardNuyen();
// 		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("I am really busy ... and hungry ... bring me {$need} bacon!");
				break;
			case 'confirm':
				$npc->reply("Its quite urgent, thanks.");
				break;
			case 'yes':
				$npc->reply('Alright!');
				break;
			case 'no':
				$npc->reply('kk');
				break;
		}
		return true;
	}
}
?>