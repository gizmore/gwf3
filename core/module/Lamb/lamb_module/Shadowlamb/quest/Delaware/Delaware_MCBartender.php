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
		list($spark, $alco) = $this->getDrinkData();
		return sprintf('Bring %d / %d %s and %d / %d %s to the bartender in the MacLaren pub.',
			$spark, self::NEED_SPARK, 'SparklingWine',
			$alco,  self::NEED_ALCO, 'Alcopop');
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
		list($spark, $alco) = $this->getDrinkData();
		
		$spark = $this->giveQuesties($player, $npc, 'SparklingWine', $spark, self::NEED_SPARK);
		$alco = $this->giveQuesties($player, $npc, 'Alcopop', $alco, self::NEED_ALCO);
		$data = array('S' => $spark, 'A' => $alco);
		$this->saveQuestData($data);
		
		if ( ($spark >= self::NEED_SPARK) && ($alco >= self::NEED_ALCO) )
		{
			$npc->reply('Thank you chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf("I still need %d SparklingWine and %d Alcopops-", (self::NEED_SPARK-$spark), (self::NEED_ALCO-$alco)));
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
				$npc->reply("Yeah, i have heard from you you ^^");
				$npc->reply("Actually i am out of some liquids. Bring me {$ns} SparklingWine and {$na} Alcopops and i will pay you {$dp}.");
				break;
			case 'confirm':
				$npc->reply("I really could need the drinks.");
				break;
			case 'yes':
				$npc->reply('Thank you i am awaiting your delivery.');
				break;
			case 'no':
				$npc->reply('Ok chummer.');
				break;
		}
		return true;
	}
}
?>