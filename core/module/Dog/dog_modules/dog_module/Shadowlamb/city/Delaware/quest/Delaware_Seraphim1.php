<?php
final class Quest_Delaware_Seraphim1 extends SR_Quest
{
// 	public function getQuestName() { return 'FirstHand'; }
// 	public function getQuestDescription() { return sprintf('Convince the Delaware Doctor to agree to Seraphim\'s implant request by asking him about hand.'); }
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 1000; }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isConvinced($player))
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Thank you so very very much. This will help me to get my business running.');
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more'));
// 			$npc->reply(sprintf('Sad to hear you could not convince him yet.'));
		}
		
		return true;
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Hello chummer :( You want to hear about my problems?");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply("I got robbed by Trolls and Goblins, and I lost my FirstHand ...");
				$npc->reply($this->lang('sr3'));
// 				$npc->reply("I wanted to get a new HandL3 implanted, but the doctor says it's illegal.");
				$npc->reply($this->lang('sr4'));
// 				$npc->reply("If you could convince him to do it anyway I would be very thankful.");
				$npc->reply($this->lang('sr5'));
// 				$npc->reply("Just ask him about \X02hand\X02.");
				break;
			case 'confirm':
				$npc->reply($this->lang('sr5'));
// 				$npc->reply("Just ask him about \X02hand\X02.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Yes.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Please.');
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
		if ($this->isConvinced($player))
		{
			return $npc->reply($this->lang('convinced'));
// 			return $npc->reply('You already convinced me.');
		}
		
		$key = 'DLW_DOC_HAND';
		$nuyen = $player->getNuyen();
		$price = $this->getRewardNuyen();
		$dp = $this->displayRewardNuyen();
		if ($nuyen < $price)
		{
			$player->setTemp($key, 1);
			return $npc->reply($this->lang('doc_price', array($dp)));
// 			return $npc->reply(sprintf("For %s I would do it.", $dp));
		}
		$player->giveNuyen(-$price);
		$player->message($this->lang('pay', array($dp)));
// 		$player->message(sprintf("You pay %s and the doctor smiles.", $dp));
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
						return $npc->reply($this->lang('doc_yes'));
// 						return $npc->reply('Yes');
					case 2:
						$player->setTemp($key, 1);
						return $npc->reply($this->lang('doc_haha'));
// 						return $npc->reply('Hahahah ^^');
					case 3:
						return $this->onConvince($npc, $player);
				}
				
			case 'no':
				switch ($temp)
				{
					case 1: break;
					case 2:
						$player->setTemp($key, $temp+1);
						return $npc->reply($this->lang('doc_ok', array($price)));
// 						return $npc->reply("Okok ... I will do it for {$price}.");
					case 3:
						$player->setTemp($key, 1);
						return $npc->reply($this->lang('doc_haha_ok'));
// 						return $npc->reply("Haha ok :)");
						
				}
				
			case 'hand':
				switch ($temp)
				{
					case 1:
						$player->setTemp($key, $temp+1);
					default:
						return $npc->reply($this->lang('doc_oh'));
// 						return $npc->reply("Haha, the old dwarf sent you? That's funny.");
				}
		}
		return $npc->reply($this->lang('doc_mh'));
// 		return $npc->reply('Pardon?');
	}
}
?>
