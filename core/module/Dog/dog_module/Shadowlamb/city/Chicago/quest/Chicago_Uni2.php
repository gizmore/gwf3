<?php
final class Quest_Chicago_Uni2 extends SR_Quest
{
	public function getQuestName() { return 'Bachelor2'; }
	public function getNeededAmount() { return 100; }
	public function getQuestDescription() { return sprintf('Bring %d/%d WaterBottles to the Chicago University Gnome', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 10; }
	public function getRewardNuyen() { return 200; }
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
			$npc->reply('Wow ... here is your money.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('We still need %d water bottles for our experiments.', $need-$have));
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
				$npc->reply("I have a funny problem now ... we need {$need} water bottles and have only {$dny} bucks ... can you organize them for us?");
				break;
			case 'confirm':
				$npc->reply("Don't worry if you say no.");
				break;
			case 'yes':
				$npc->reply('Heh ... alright then!');
				break;
			case 'no':
				$npc->reply('Ok');
				break;
		}
		return true;
	}
}
?>