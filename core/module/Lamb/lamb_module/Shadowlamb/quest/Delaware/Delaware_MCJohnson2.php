<?php
final class Quest_Delaware_MCJohnson2 extends SR_Quest
{
	public function getQuestName() { return 'Gem'; }
	public function getQuestDescription() { return "Fight CaveTrolls until you get an Emerald and bring this to Mr.Johnson in the MacLarens pub in Delaware."; }
	public function getNeededAmount() { return 1; }
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 2500; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->giveQuesties($player, $npc, 'Emerald', 0, 1))
		{
			$npc->reply("Awesome, you are a very valuable runner! My client will be very happy.");
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply('My client is still waiting for the gem.');
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
//		$kn = self::KILLS_NEEDED;
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("A client has a delicate problem. He got robbed by several CaveTrolls who stole a big Emerald.");
				$npc->reply("Your job would be to get the gem back.");
				$npc->reply("Do you think you can do it?");
//				return false;
				break;
			case 'confirm':
				$npc->reply("I will pay you $dp.");
				break;
			case 'yes':
				$npc->reply("Great, I will await you back soon.");
				break;
			case 'no':
				$npc->reply('Ok.');
				break;
		}
		return true;
	}
}
?>
