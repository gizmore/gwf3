<?php
final class Quest_Seattle_BD1 extends SR_Quest
{
	const NEED_LONG = 3;
	const NEED_BROAD = 4;
	const NEED_SHORT = 5;
	
// 	public function getQuestName() { return 'PoorSmith1'; }
// 	public function getQuestDescription() { list($hl,$nl,$hb,$nb,$hs,$ns)=$this->getBDQuestData(); return sprintf('Bring %s/%s LongSword, %s/%s BroadSword, %s/%s ShortSword to the Seattle Blacksmith.', $hl,$nl,$hb,$nb,$hs,$ns); }
	public function getQuestDescription()
	{
		list($hl,$nl,$hb,$nb,$hs,$ns) = $this->getBDQuestData();
		return $this->lang('descr', array($hl, $nl, $hb, $nb, $hs, $ns));
	}
	
	public function getBDQuestData()
	{
		$data = $this->getQuestData();
		return count($data) ? $data : array(0,self::NEED_LONG, 0,self::NEED_BROAD, 0,self::NEED_SHORT);
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		list($hl,$nl,$hb,$nb,$hs,$ns)=$this->getBDQuestData();
		
		$hl = $this->giveQuesties($player, $npc, 'LongSword', $hl, $nl);
		$hb = $this->giveQuesties($player, $npc, 'BroadSword', $hb, $nb);
		$hs = $this->giveQuesties($player, $npc, 'ShortSword', $hs, $ns);
		
		$this->saveQuestData(array($hl,$nl,$hb,$nb,$hs,$ns));
		
		if ( ($hl >= $nl) && ($hb >= $nb) && ($hs >= $ns) )
		{
			$npc->reply($this->lang('thanks1'));
// 			$npc->reply('Thank you so much, now I can carry on with my business.');
			$this->onSolve($player);
			$npc->reply($this->lang('thanks2'));
// 			$npc->reply('Here, I have saved these items from beeing plundered.');
			$player->giveItems($this->getReward($player), $npc->getName());
		}
		else
		{
			$npc->reply($this->lang('more', array(($nl-$hl), ($nb-$hb), ($ns-$hs))));
// 			$npc->reply(sprintf('Please bring me also %s LongSword, %s BroadSword and %s ShortSword.', ($nl-$hl), ($nb-$hb), ($ns-$hs)));
		}
		
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply($this->lang($word));
// 				$npc->reply('Could you please help me?');
				break;
			case 'shadowrun':
				$npc->reply($this->lang('shadowrun1'));
// 				$npc->reply('I have been robbed by a horde of AngryElves and Orks. Again. There is not much left.');
//				sleep(2);
				$npc->reply($this->lang('shadowrun2'));
// 				$npc->reply('If you could only organize me some unstatted swords to get back in business, I could only spare a few rare items, though.');
				$npc->reply($this->lang('shadowrun3', array($npc->getName())));
// 				$player->message($npc->getName().' looks at you questioning.');
				
				break;
			case 'yes':
				$npc->reply($this->lang($word, array(self::NEED_LONG, self::NEED_BROAD, self::NEED_SHORT)));
// 				$npc->reply(sprintf('Please bring me %s LongSword, %s BroadSword and %s ShortSword.', self::NEED_LONG, self::NEED_BROAD, self::NEED_SHORT));
				break;
			case 'no':
				$npc->reply($this->lang($word));
// 				$npc->reply('Feel free to trade then.');
				break;
		}
		return true;
	}
	
	public function getReward(SR_Player $player)
	{
		$possible = array(array('LO_Rune_of_attack:0.3', 'Rune_of_body:0.5'));
		if ($player->getBase('bows') >= 0)
		{
			$possible[] = array('SportBow_of_bows:1,attack:1', 'Ammo_Arrow', 'Ammo_Arrow');
		}
		if ($player->getBase('pistols') >= 0)
		{
			$possible[] = array('AresPredator_of_attack:1,max_dmg:1', 'Ammo_9mm');
		}
		if ($player->getBase('ninja') >= 0)
		{
			$possible[] = array('NinjaSword');
		}
		if ($player->getBase('magic') >= 0)
		{
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
