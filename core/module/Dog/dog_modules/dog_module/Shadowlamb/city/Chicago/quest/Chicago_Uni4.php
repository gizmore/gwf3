<?php
final class Quest_Chicago_Uni4 extends SR_Quest
{
	public function getQuestName() { return 'Bachelor4'; }
	public function getNeededAmount() { return 2; }
	public function getQuestDescription() { return sprintf('Bring %d/%d ScrollOfWisdom to the Chicago University Gnome', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 1; }
	public function getRewardNuyen() { return 100; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'ScrollOfWisdom', $have_before, $need);
		
		if ($have > $have_before)
		{
			$npc->reply('hehe thanks.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Oh you want some money for them? Here you are.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('I can still need %d scrolls for my prank.', $need-$have));
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
				$npc->reply("I am currently very busy ... why you keep asking? well ... ");
				$npc->reply("I want to play a prank to some students ... can you bring me {$need} ScrollOfWisdom? ... that will be a nice prank.");
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