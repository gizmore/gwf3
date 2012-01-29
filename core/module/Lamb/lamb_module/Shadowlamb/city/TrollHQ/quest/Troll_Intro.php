<?php
final class Quest_Troll_Intro extends SR_Quest
{
	const KEY = 'troll_heat';
	
	public function getQuestName() { return 'TrollIntro'; }
	public function getQuestDescription() { return 'Turn on the heat in the TrollHQ and return to Larry, the TrollChief.'; }
	
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 200; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($player->getConst(self::KEY))
		{
			$npc->reply('Yes better.');
			return $this->onSolve($player);
		}
		else
		{
			$npc->reply('Still cold.');
		}
		return false;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("You want job? From me?");
				$npc->reply("Go to the cellar and increase heat. Me is cold!");
				break;
			case 'confirm':
				$npc->reply("Go!");
				break;
			case 'yes':
				$npc->reply("You still here?");
				break;
			case 'no':
				$npc->reply('You should go!');
				break;
		}
		return true;
		
	}
}
?>