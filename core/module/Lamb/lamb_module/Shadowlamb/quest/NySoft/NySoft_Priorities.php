<?php
final class Quest_NySoft_Priorities extends SR_Quest
{
	public static $PRIORITY_ITEMS = array(
		'Pizza' => 6,
		'Coke' => 8,
		'SmallBeer' => 6,
	);
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 600; }
	public function getQuestName() { return 'Priorities'; }
	public function getQuestDescription()
	{
		$data = $this->getQuestData();
		$out = array();
		foreach (self::$PRIORITY_ITEMS as $itemname => $amt)
		{
			$out[] = sprintf("%d/%d %s", $data[$itemname], $amt, $itemname);
		}
		return sprintf('Bring %s to Christian in the NySoft office, Deleware.', GWF_Array::implodeHuman($out));
	}
	
	public function getTheQuestData()
	{
		$data = $this->getQuestData();
		if (count($data) > 0)
		{
			return $data;
		}
		$data = array();
		foreach (self::$PRIORITY_ITEMS as $itemname => $amt)
		{
			$data[$itemname] = 0;
		}
		return $data;
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getTheQuestData();
		$need = $this->getTheQuestData();
		$given = 0;
		$need_total = 0;
		$have_total = 0;
		foreach (self::$PRIORITY_ITEMS as $itemname => $amt)
		{
			$hbe = $have[$itemname]; # before
			$hav = $this->giveQuesties($player, $npc, $itemname, $have[$itemname], $amt); # after
			$have[$itemname] = $hav;
			$need[$itemname] = $amt - $hav;
			$given += $hav - $hbe;
			$need_total += $amt;
			$have_total += $hav;
		}
		
		if ($given > 0)
		{
			$npc->reply("Thanks chummer!");
			$this->saveQuestData($have);
		}
		
		if ($have_total >= $need_total)
		{
			$npc->reply('Thanks man, now i can get back to work!');
			$this->onSolve($player);
		}
		else 
		{
			$npc->reply('Where are our supplies?');
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
				$npc->reply("Oh well ... you can support us with supplies, so we can get back to work.");
				$npc->reply("Interested?");
				break;
			case 'confirm':
				$npc->reply("Interested?");
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