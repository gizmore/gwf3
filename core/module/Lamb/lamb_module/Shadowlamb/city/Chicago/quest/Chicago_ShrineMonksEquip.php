<?php
final class Quest_Chicago_ShrineMonksEquip extends SR_Quest
{
	private static $NEED = array(
		'ChikaTabi' => 3,
		'Uwagi' => 3,
		'Tenugui' => 3,
		'Hakama' => 3,
		'SteelNunchaku' => 3,
	);
	
	public function getQuestName() { return 'Ninjitsu'; }
	public function getRewardXP() { return 15; }
	public function getRewardNuyen() { return 750; }
	
	public function getQuestDescription()
	{
		$out = array();
		$data = $this->getMonkData();
		foreach ($data as $itemname => $have)
		{
			$out[] = sprintf('%d/%d %s', $have, self::$NEED[$itemname], $itemname);
		}
		return sprintf('Bring %s to the monks in Chicago Shrine.', GWF_Array::implodeHuman($out));
	}
	
	public function getMonkData()
	{
		$data = $this->getQuestData();
		if (count($data) === 0)
		{
			foreach (self::$NEED as $itemname => $amt)
			{
				$data[$itemname] = 0;
			}
		}
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getMonkData();
		$have = $this->getMonkData();
		$completed = 0;
		foreach (self::$NEED as $itemname => $amt)
		{
			$have[$itemname] = $this->giveQuesties($player, $npc, $itemname, $have[$itemname], $amt);
			
			if ($have[$itemname] >= $amt)
			{
				$completed++;
			}
		}
		
		$this->saveQuestData($have);
		
		if ($completed >= count($have))
		{
			$npc->reply('You are a true warrior and worthwhile for our clan.');
			$npc->reply('I will teach you a real skill, which increases your magic attacks.');
			$player->increaseField('spellatk', 1);
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply('I see your mission is not completed yet.');
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("If you help us again, will reward you very well... We now want to reinforce our monks with some decent ninja equipment.");
				$npc->reply(sprintf('Can you please bring us %s?', $this->getQuestionOut($player)));
				return true;
			case 'confirm':
				return $npc->reply("Can you?");
			case 'yes':
				return $npc->reply('May buddha guide your way.');
			case 'no':
				return $npc->reply('May buddha guide your path.');
		}
	}
	
	private function getQuestionOut(SR_Player $player)
	{
		$back = array();
		foreach (self::$NEED as $itemname => $need)
		{
			$back[] = sprintf('%d %s', $need, $itemname);
		}
		return GWF_Array::implodeHuman($back);
	}
}
?>