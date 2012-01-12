<?php
final class Quest_Chicago_SaleSmith1 extends SR_Quest
{
	const NEED_SCAN1 = 4;
	const NEED_SCAN2 = 2;
	const NEED_CREDS = 2;
	public function getQuestName() { return 'Inventory'; }
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 0; }
	public function getRewardItems() { return array('Holostick','Scanner_v3'); }
	public function getTheQuestData()
	{
		$data = $this->getQuestData();
		return count($data) ? $data : array(0,self::NEED_SCAN1, 0,self::NEED_SCAN2, 0,self::NEED_CREDS);
	}
	
	public function getQuestDescription()
	{
		list($h1,$n1,$h2,$n2,$hc,$nc)=$this->getTheQuestData();
		return sprintf(
			'Bring %d/%d ScannerV1, %d/%d ScannerV2 and %d/%d Credsticks to the Chicago Blacksmith Salesmen.',
			$h1,$n1, $h2,$n2, $hc,$nc
		);
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		list($h1,$n1,$h2,$n2,$hc,$nc)=$this->getTheQuestData();
		
		$have_before = $h1 + $h2 + $hc;
	
		$h1 = $this->giveQuesties($player, $npc, 'Scanner_v1', $h1, $n1);
		$h2 = $this->giveQuesties($player, $npc, 'Scanner_v2', $h2, $n2);
		$hc = $this->giveQuesties($player, $npc, 'ShortSword', $hc, $nc);
	
		$have_after = $h1 + $h2 + $hc;
		
		$this->saveQuestData(array($h1,$n1,$h2,$n2,$hc,$nc));
		
		if ($have_after > $have_before)
		{
			$npc->reply('Thanks!');
		}
	
		if ( ($h1 >= $n1) && ($h2 >= $n2) && ($hc >= $nc) )
		{
			$npc->reply('Thank you ... Here, i can only compensate you with a few items.');
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('Please bring me also %d ScannerV1, %d ScannerV2, %d Credstick(s).', ($n1-$h1), ($n2-$h2), ($nc-$hc)));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Heh ... well ... lol ... well ...");
				$npc->reply("You can indeed do a job for me ^^");
				$player->message('The salesman whispers: "I messed up the yearly inventory" ... ');
				$npc->reply("I am going into own business and purchase Scanners and Credsticks.");
				$player->message('The salesman whispers: "I will compensate you ..." ');
				break;
			case 'confirm':
				$npc->reply("Thank you for your help in advance.");
				break;
			case 'yes':
				$npc->reply('Thank you chummer.');
				break;
			case 'no':
				$npc->reply('Laters chummer.');
				break;
		}
		return true;
	}
}
?>