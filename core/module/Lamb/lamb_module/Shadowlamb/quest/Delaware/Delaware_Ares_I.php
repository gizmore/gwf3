<?php
final class Quest_Delaware_Ares_I extends SR_Quest
{
	public function getQuestName() { return 'Pistols'; }
	public function getQuestDescription() { return sprintf('Bring an AresViper11 to the Ares salesman in Delaware.'); }
	public function getNeededAmount() { return 1; }
	
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 500; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$need = $this->getNeededAmount();
		$have_before = $this->getAmount();
		if (1 === $this->giveQuesties($player, $npc, 'AresViper11', $have_before, $need))
		{
			$npc->reply('Thank you chummer. This will totally fit in my collection.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply('Bring me the gun so I can give it to Mr... Err put it in my collection.');
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("You are looking for a job? Well ...");
				$npc->reply("I am a collector of fireweapons, and I still need an AresViper eleven.");
				$npc->reply(sprintf("If you bring me one and I will pay you %s.", $this->displayRewardNuyen()));
				break;
			case 'confirm':
				$npc->reply("If I get one gun from some runners we should find the right gun.");
				break;
			case 'yes':
				$npc->reply('Thank you, chummer. I hope you can organize one soon!');
				break;
			case 'no':
				$npc->reply('Ok.');
				break;
		}
		return true;
	}
}
?>

