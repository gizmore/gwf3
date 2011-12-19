<?php
/**
 * Bring Alcopop and 
 * @author gizmore
 */
final class Quest_Delaware_MCBartender extends SR_Quest
{
	const NEED_SPARK = 8;
	const NEED_ALCO = 16;
	public function getQuestName() { return 'Drank'; }
	public function getQuestDescription()
	{
		$data = $this->getDrinkData();
		return sprintf('Bring %d / %d %s and %d / %d %s to the bartender in the MacLaren pub.',
			$data['S'], self::NEED_SPARK, 'SparklingWine',
			$data['A'], self::NEED_ALCO, 'Alcopop');
	}
	public function getNeededAmount() { return 5; }
	public function getRewardNuyen() { return 1200; }
	
	public function getDrinkData()
	{
		$data = $this->getQuestData();
		if (!isset($data['S'])) $data['S'] = 0;
		if (!isset($data['A'])) $data['A'] = 0;
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getDrinkData();
		$data['A'] = $this->giveQuesties($player, $npc, 'Alcopop', $data['A'], self::NEED_ALCO);
		$data['S'] = $this->giveQuesties($player, $npc, 'SparklingWine', $data['S'], self::NEED_SPARK);
		$this->saveQuestData($data);
		
		if ( ($data['S'] >= self::NEED_SPARK) && ($data['A'] >= self::NEED_ALCO) )
		{
			$npc->reply('Thank you chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf("I still need %d SparklingWine and %d Alcopops-", (self::NEED_SPARK-$data['S']), (self::NEED_ALCO-$data['A'])));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$ns = self::NEED_SPARK;
		$na = self::NEED_ALCO;
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Yeah, I have heard from you you ^^");
				$npc->reply("Actually I am out of some liquids. Bring me {$ns} SparklingWine and {$na} Alcopops and I will pay you {$dp}.");
				break;
			case 'confirm':
				$npc->reply("I really could need the drinks.");
				break;
			case 'yes':
				$npc->reply('Thank you I am awaiting your delivery.');
				break;
			case 'no':
				$npc->reply('Ok chummer.');
				break;
		}
		return true;
	}
}
?>