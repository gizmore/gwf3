<?php
final class Quest_Troll_Feed extends SR_Quest
{
	const NEED_BACON = 4;
	const NEED_BEER = 6;
	
	public function getRewardXP() { return 5; }
	public function getRewardNuyen() { return 500; }
	
	public function getQuestName() { return 'TrollFeed'; }
	public function getQuestDescription()
	{
		$data = $this->getTrollFeedData();
		return sprintf('Bring %d/%d Bacon and %d/%d LargeBeer to Larry, the TrollChief.', $data['bacon'], self::NEED_BACON, $data['beer'], self::NEED_BEER);

	}
	
	private function getTrollFeedData()
	{
		$data = $this->getQuestData();
		if (!isset($data['bacon'])) { $data['bacon'] = 0; }
		if (!isset($data['beer'])) { $data['beer'] = 0; }
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getTrollFeedData();
		
		$have_bacon = $this->giveQuesties($player, $npc, 'Bacon', $data['bacon'], self::NEED_BACON);
		$have_beer = $this->giveQuesties($player, $npc, 'LargeBeer', $data['beer'], self::NEED_BEER);
		
		$data['bacon'] = $have_bacon;
		$data['beer'] = $have_beer;
		$this->saveQuestData($data);
		
		if ( ($have_bacon >= self::NEED_BACON) && ($have_beer >= self::NEED_BEER) )
		{
			return $this->onSolve($player);
		}
		else
		{
			$player->message('I have still hungry!');
		}
		return false;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Haha, you really want jobs.");
				$npc->reply("I am hungry. Bring Bacon and Beer!");
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