<?php
final class Quest_Chicago_Uni3 extends SR_Quest
{
	public function getQuestName() { return 'Bachelor3'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Emerald to the Chicago University Gnome', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 500; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Emerald', $have_before, $need);
		
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
			return $npc->reply(sprintf('I still need %d emerald for my experiments.', $need-$have));
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
				$npc->reply("Hmmm why do you keep asking chummer ... i could need {$need} emeralds now ... but have only {$dny} :/");
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