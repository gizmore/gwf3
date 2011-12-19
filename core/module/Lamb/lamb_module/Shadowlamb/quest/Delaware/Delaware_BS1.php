<?php
final class Quest_Delaware_BS1 extends SR_Quest
{
	public function getQuestName() { return 'Amace'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Mace to the Delaware Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 800; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have_after = $this->giveQuesties($player, $npc, 'Mace', $have_before, $need);
		$this->saveAmount($have_after);
		if ($have_after >= $need)
		{
			$npc->reply('Thank you very much, chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf("Please bring me %d more Maces. Thank you.", $need-$have_after));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("You are looking for a job?");
				$npc->reply("Well, as you can #view I have a nice pile of swords, but no other melee weapons.");
				$npc->reply(sprintf("Maybe you could bring me %d Mace and I will reward you with %s?", $need, $this->displayRewardNuyen()));
				break;
			case 'confirm':
				$npc->reply("What do you think?");
				break;
			case 'yes':
				$npc->reply('Alright, great :)');
				break;
			case 'no':
				$npc->reply('Oh, ok.');
				break;
		}
		return true;
	}
	
}
?>