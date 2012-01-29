<?php
final class Quest_Chicago_ShrineMonksRevenge extends SR_Quest
{
	private static $NEED = array(40, 40, 40);
	private static $NAMES = array('CyberGoblins', 'CyberOrks', 'CyberTrolls');
	
	public function getQuestName() { return 'MonkeyRevenge'; }
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 800; }

	public function getQuestDescription()
	{
		$data = $this->getKillData();
		list($hg, $ho, $ht) = $data;
		return sprintf('Kill %d/%d CyberGoblins, %d/%d CyberOrks and %d/%d CyberTrolls, then return to Chicago Shrine.',
			$hg, self::$NEED[0], $ho, self::$NEED[1], $ht, self::$NEED[2]
		);
	}
	
	public function getKillData()
	{
		$data = $this->getQuestData();
		return count($data) === 3 ? $data : array(0, 0, 0);
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getKillData();
		list($hg, $ho, $ht) = $data;
		
		$ng = self::$NEED[0] - $hg;
		$no = self::$NEED[1] - $ho;
		$nt = self::$NEED[2] - $ht;
		
		if ( ($ng <= 0) && ($no <= 0) && ($nt <= 0) )
		{
			$npc->reply('We thank you very much in the name of our little shrine.');
			return $this->onSolve($player);
		}
		else
		{
			return
				$npc->reply(sprintf('You punished %d/%d Goblins, %d/%d Orks and %d/%d Trolls. More!',
					$hg, self::$NEED[0], $ho, self::$NEED[1], $ht, self::$NEED[2]
				));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("You are a runner? ... We can need your dirty services ...");
				$npc->reply(sprintf('We need to take revenge on the cybertrolls ... please kill %d CyberGoblins, %d CyberOrks and %d CyberTrolls', self::$NEED[0], self::$NEED[1], self::$NEED[2]));
				$npc->reply("If you do us some favors, we will reward you greatly ... accept?");
				return true;
			case 'confirm':
				return $npc->reply("Do you?");
			case 'yes':
				return $npc->reply('May buddha guide your way.');
			case 'no':
				return $npc->reply('May buddha guide your path.');
		}
	}
	
	public function onKilled(SR_Player $player, $type)
	{
		$type--;
		$data = $this->getKillData();
		$data[$type] += 1;
		$this->saveQuestData($data);
		return $player->message(sprintf('Now you killed %d/%d %s for the monks revenge quest.', $data[$type], self::$NEED[$type], self::$NAMES[$type]));
	}
	
}
?>