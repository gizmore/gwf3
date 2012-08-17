<?php
final class Chicago_Alchemist_NPC extends SR_TalkingNPC
{
	public function getName() { return 'Newton'; }
	
	public function getNPCModifiers()
	{
		return array('race'=>'gnome');
	}
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_Alchemist1'); }                                                                                                                                                                                                                                                                                                                                                                                                                private function onTellSecret(SR_Player $player) { $this->reply('Hehe sorry chummer, i was mean.'); $this->reply('Ugah didn´t finish the chapter, but i know his secrets :)'); $this->reply(GWF_AES::decrypt4(trim(base64_decode('MzD7FCNVFHpiqK1/o0BAt/gdE3adHwRtcIRttaYqZ73/sHcAru3gD05I8th1XRzY0eHRU6iySi2a1BOl3Y2qmWUtPC+72nLP7nQB6M4FJXu8+xscRKTXOUb3CLoxYtvynmzAUD4Nn+p6vd0yhWk1++/u+VIvEoW01jvKNblzxH3GVYx/joqMlUHiNKZP2jBPdxwyiFeS630yL6bfJCgH3A=='), LAMB_PASSWORD2, LAMB_PASSWORD2))); $this->reply('This is all i can do for your, k thx bye :)'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		$b = chr(2);
		
		switch ($word)
		{
			case 'seattle': return $this->reply('Renraku is not as hitech as you might think... you cannot bend the universe as you wish.');
// 			case 'shadowrun':
			case 'cyberware': return $this->reply("Cyberware is bad for your essence. {$b}Alchemy{$b} safes lifes.");
			case 'magic': return $this->reply('Magic knowledge is required to perform powerful alchemy.');
			case 'hire': return $this->reply('You cannot hire me, chummer.');
			case 'blackmarket': return $this->reply('You won\'t get illegal stuff here, chummer.');
			case 'bounty': return $this->reply('You won\'t get illegal stuff here, chummer.');
			case 'seattle': return $this->reply('Seattle is not as hitech as you might think... all are cooking with water.');
			case 'alchemy': return $this->reply('I can teach you alchemy for a little favor.');
			case 'invite': return $this->reply('I have no time for parties.');
			case 'malois': return $this->reply('Never heard of him.');
			
			# Chapter IV
			case 'scrolls': return $this->onScrolls($player);
			case 'yes': return $this->onYes($player);
			case 'no': return $this->onNo($player);
			
			case 'negotiation': return $this->reply('Negotiate negotiate .... all want to negotiate ... my prices are fair.');
			
			case 'hello': 
			default:
				return $this->reply("Hello my name is Newton, your alchemic milestone :)");
		}
	}

	############################
	### Ugly Chapter IV Code ###
	############################
	
	const SCRL_COUNT = 'CHIV_SCT';
	const TMP_SCROLL = 'CHIV_TSC';
	
	private function onScrolls(SR_Player $player)
	{
		$tmp = $player->getTemp(self::TMP_SCROLL, 0);
		if ($tmp === 0)
		{
			$this->reply('Ugah sent you to bring me scrolls?! ... Do you have some?');
			$player->setTemp(self::TMP_SCROLL, 1);
		}
		else
		{
			$this->reply('So? Do you have some scrolls?');
		}
	}

	private function onYes(SR_Player $player)
	{
		$tmp = $player->getTemp(self::TMP_SCROLL, 0);
		if ($tmp === 0)
		{
			$this->reply('Yes? Yes what!');
		}
		else
		{
			$this->onGiveScrolls($player);
			$player->unsetTemp(self::TMP_SCROLL);
		}
	}

	private function onNo(SR_Player $player)
	{
		$tmp = $player->getTemp(self::TMP_SCROLL, 0);
		if ($tmp === 0)
		{
			$this->reply('No, i get it.');
		}
		else
		{
			$this->onCheckNo($player);
		}
	}
	
	private function onGiveScrolls(SR_Player $player)
	{
		$have = SR_PlayerVar::getVal($player, self::SCRL_COUNT, 0);
		$need = PHP_INT_MAX;
		
		$have_after = $this->giveQuesties($player, 'ScrollOfWisdom', $have, $need);
		$given = $have_after - $have;
		
		if ($given > 0)
		{
			$this->reply(sprintf('Thanks buddy, you now have given me %s scrolls iirc :)', $have_after));
			SR_PlayerVar::setVal($player, self::SCRL_COUNT, $have_after);
		}
		else
		{
			$this->reply('Hey, you don´t have a scroll.');
		}

		$player->unsetTemp(self::TMP_SCROLL);
	}
	
	private function onCheckNo(SR_Player $player)
	{
		
		$have = SR_PlayerVar::getVal($player, self::SCRL_COUNT, 0);
		$need = 4;
		
		if ($have > $need)
		{
			$this->onTellSecret($player);
		}
		else
		{
			$this->reply('Ok ok... then not, chummer.');
		}
		
		$player->unsetTemp(self::TMP_SCROLL);
	}

	private function onTellSercet(SR_Player $player)
	{
		$this->reply('Hehe sorry chummer, i was mean.'); # Still am! >:-|
		$this->reply('Ugah didn´t finish the chapter, but i know his secrets :)');
		$this->reply('Goto https://www.wechall.net/challenge/lamb/shadowlamb4/index.php_, use IamStillVeryMean as the random string, and figure it out yourself...');
		$this->reply('This is all i can do for your, k thx bye :)');
	}
}
?>