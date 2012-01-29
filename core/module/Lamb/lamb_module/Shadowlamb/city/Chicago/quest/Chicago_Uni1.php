<?php
final class Quest_Chicago_Uni1 extends SR_Quest
{
	public function getQuestName() { return 'Bachelor1'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Arch Staffs to the Chicago University Gnome', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 900; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'ArchStaff', $have_before, $need);
		
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
			return $npc->reply(sprintf('I still need %d Arch Staffs for my experiments.', $need-$have));
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
				$npc->reply("You are good when it comes to critical missions, right?");
				$npc->reply("Well, i have some problems ... and the first one is actually about money.");
				$npc->reply("I need {$need} ArchStaffs, but can only pay {$dny}. Maybe you can help?");
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