<?php
final class Quest_Delaware_Seraphim1 extends SR_Quest
{
	public function getQuestName() { return 'FirstHand'; }
	public function getQuestDescription() { return sprintf('Convince the Delaware Doctor to implant Seraphim a new hand.'); }
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 1000; }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isConvinced($player))
		{
			$npc->reply('Thank you so very very much. This will help me to get my business running.');
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('Sad to hear you could not convince him yet.'));
		}
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Hello chummer :( You want to hear about my problems?");
				$npc->reply("I got robbed by Trolls and Goblins, and i lost my FirstHand ...");
				$npc->reply("I wanted to get a new HandL3 implanted, but the doctor says it's illegal.");
				$npc->reply("If you could convince him todo it anyway i would be very thankful.");
				$npc->reply("Just ask him about \X02hand\X02.");
				break;
			case 'confirm':
				$npc->reply("Just ask him about \X02hand\X02.");
				break;
			case 'yes':
				$npc->reply('Yes.');
				break;
			case 'no':
				$npc->reply('Please.');
				break;
		}
		return true;
	}
	
	public function isConvinced(SR_Player $player)
	{
		$data = $this->getQuestData();
		return isset($data['C']);
	}
	
	public function onConvince(Delaware_Doctor $npc, SR_Player $player)
	{
		$key = 'DLW_DOC_HAND';
		$nuyen = $player->getNuyen();
		$price = $this->getRewardNuyen();
		$dp = $this->displayRewardNuyen();
		if ($nuyen < $price)
		{
			$player->setTemp($key, 1);
			return $npc->reply(sprintf("For %s i would do it.", $dp));
		}
		
		$player->message(sprintf("You pay %s and the doctor smiles.", $dp));
		return $this->onConvinced($npc, $player);
	}
	
	public function onConvinced(Delaware_Doctor $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		$data['C'] = 1;
		return $this->saveQuestData($data);
	}
	
	public function onDoctorTalk(Delaware_Doctor $npc, SR_Player $player, $word)
	{
		$price = $this->displayRewardNuyen();
		
		$key = 'DLW_DOC_HAND';
		if (false === $player->hasTemp($key))
		{
			$player->setTemp($key, 1);
		}
		$temp = $player->getTemp($key);
		
		switch ($word)
		{
			case 'yes':
				switch ($temp)
				{
					case 1:
						return $npc->reply('Yes');
					case 2:
						$player->setTemp($key, 1);
						return $npc->reply('Hahahah ^^');
					case 3:
						return $this->onConvince($npc, $player);
				}
				
			case 'no':
				switch ($temp)
				{
					case 1: break;
					case 2:
						$player->setTemp($key, $temp+1);
						return $npc->reply("Okok ... I will do it for {$price}.");
					case 3:
						$player->setTemp($key, 1);
						return $npc->reply("Haha ok :)");
						
				}
				
			case 'hand':
				switch ($temp)
				{
					case 1:
						$player->setTemp($key, $temp+1);
					default:
						return $npc->reply("Haha, the old dwarf sent you? That's funny.");
				}
		}
		return $npc->reply('Pardon?');
	}
}
?>