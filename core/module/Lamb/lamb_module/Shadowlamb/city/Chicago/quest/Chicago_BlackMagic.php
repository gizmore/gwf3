<?php
final class Quest_Chicago_BlackMagic extends SR_Quest
{
	public function getQuestName() { return 'BlackMagic'; }
	public function getRewardNuyen() { return 100; }
	public function getRewardXP() { return 1; }
	public function getQuestDescription() { return sprintf('After you have solved all temple quests, return to the black magician in Chicago.'); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$quests = array('Chicago_TempleB', 'Chicago_TempleG', 'Chicago_TempleW');
		
		$done = 0;
		
		foreach ($quests as $name)
		{
			if (false === ($quest = SR_Quest::getQuest($player, $name)))
			{
				$player->message('Quest not found 0815!');
				return false;
			}
			
			if ($quest->isDone($player))
			{
				$done++;
			}
		}
		
		if ($done < count($quests))
		{
			$player->message(sprintf('It seems like you only got %d of the temple quests done.', $done));
			return true;
		}
		
		$npc->reply('Excellent. I will raise your magic by 1, chummer.');
		$player->increaseField('magic');
		$player->modify();
		return $this->onSolve($player);
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
	
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Return to me when you solved all Chicago temple quests.");
				break;
			case 'confirm':
				$npc->reply("One hand washes the other.");
				break;
			case 'yes':
				$npc->reply('Good luck chummer.');
				break;
			case 'no':
				$npc->reply('See ya, chummer.');
				break;
		}
		return true;
	}
}
?>