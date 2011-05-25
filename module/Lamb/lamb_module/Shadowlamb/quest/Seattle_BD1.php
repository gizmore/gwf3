<?php
final class Quest_Seattle_BD1 extends SR_Quest
{
	const NEED_LONG = 2;
	const NEED_BROAD = 4;
	const NEED_SHORT = 6;
	public function getQuestName() { return 'PoorSmith1'; }
	public function getBDQuestData()
	{
		$data = $this->getQuestData();
		return count($data) ? $data : array(0,self::NEED_LONG, 0,self::NEED_BROAD, 0,self::NEED_SHORT);
	}
	
	public function getQuestDescription() { list($hl,$nl,$hb,$nb,$hs,$ns)=$this->getBDQuestData(); return sprintf('Bring %s/%s LongSword, %s/%s BroadSword, %s/%s ShortSword to the Seattle Blacksmith.', $hl,$nl,$hb,$nb,$hs,$ns); }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		list($hl,$nl,$hb,$nb,$hs,$ns)=$this->getBDQuestData();
		
		$hl = $this->giveQuesties($player, $npc, 'LongSword', $hl, $nl);
		$hb = $this->giveQuesties($player, $npc, 'BroadSword', $hb, $nb);
		$hs = $this->giveQuesties($player, $npc, 'ShortSword', $hs, $ns);
		
		$this->saveQuestData(array($hl,$nl,$hb,$nb,$hs,$ns));
		
		if ( ($hl >= $nl) && ($hb >= $nb) && ($hs >= $ns) )
		{
			$npc->reply('Thank you so much, now i can carry on with my business.');
			$this->onSolve($player);
			$npc->reply('Here, i have saved these items from beeing plundered.');
			$player->giveItems($this->getReward($player));
		}
		else
		{
			$npc->reply(sprintf('Please bring me also %s LongSword, %s BroadSword and %s ShortSword.', ($nl-$hl), ($nb-$hb), ($ns-$hs)));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply('Could you please help me?');
				break;
			case 'shadowrun':
				$npc->reply('I have been robbed by a horde of AngryElves and Orks. Again. There is not much left.');
				sleep(2);
				$npc->reply('If you could only organize me some unstatted swords to get back in business, i could only spare a few rare items, though.');
				$player->message($npc->getName().' looks at you questioning.');
				break;
			case 'yes':
				$npc->reply(sprintf('Please bring me %s LongSword, %s BroadSword and %s ShortSword.', self::NEED_LONG, self::NEED_BROAD, self::NEED_SHORT));
				break;
			case 'no':
				$npc->reply('Feel free to trade then.');
				break;
		}
	}
	
	public function getReward(SR_Player $player)
	{
		$possible = array(array('LO_Rune_of_attack:0.3', 'Rune_of_body:0.5'));
		if ($player->getBase('bows') >= 0) {
			$possible[] = array('SportBow_of_bows:1,attack:1', 'Ammo_Arrow', 'Ammo_Arrow');
		}
		if ($player->getBase('pistols') >= 0) {
			$possible[] = array('AresPredator_of_attack:1,max_dmg:1', 'Ammo_9mm');
		}
		if ($player->getBase('ninja') >= 0) {
			$possible[] = array('NinjaSword');
		}
		if ($player->getBase('magic') >= 0) {
			$possible[] = array('ElvenStaff_of_magic:2,max_hp:2');
		}
		
		$reward = $possible[array_rand($possible, 1)];
		$back = array();
		foreach ($reward as $itemname)
		{
			$back[] = SR_Item::createByName($itemname);
		}
		return $back;
	}
}
?>
