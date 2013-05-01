<?php
final class Quest_Seattle_Barkeeper extends SR_Quest
{
	public function getNeededAmount() { return 20; } 
	
// 	public function getQuestName() { return 'TheParty'; }
// 	public function getQuestDescription() { return sprintf('Invite %s/%s Citizens to the Deckers party, then return to the pub and talk with the barkeeper.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function onInviteCitizen(SR_NPC $npc, SR_Player $player, $amt=1)
	{
		$this->increase('sr4qu_amount', $amt);
		$player->message($this->lang('invite', array($this->getAmount(), $this->getNeededAmount())));
// 		$player->message(sprintf('Now you have invited %s of %s citizens to the Deckers party.', $this->getAmount(), $this->getNeededAmount()));
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('friday'));
// 			$npc->reply('Please invite more guests. The party is on friday. Which rockband should I take?');
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$xp = 6;
		$ny = 1000;
		$player->message($this->lang('reward1', array($ny, $xp)));
// 		$player->message(sprintf('The barkeeper hands you %s Nuyen and smiles: "Good job. We surely will have more guests now.". You also gain %s XP.', $ny, $xp));
		$player->giveNuyen($ny);
		$player->giveXP($xp);
		$player->message($this->lang('reward2'));
// 		$player->message(sprintf('Here, take this as a bonus reward. Guests forgot these items lately.'));
		$player->giveItems(Shadowfunc::randLootNItems($player, 15, 2));
	}
	
	public function onTryInvite(SR_TalkingNPC $npc, SR_Player $player)
	{
		if (!$this->isInQuest($player))
		{
			return $npc->reply($this->lang('no_quest'));
// 			$npc->reply('You invite me to a party? Maybe try #join or #say hire.');
// 			break;
		}
		
		$key2 = 'Seattle_Citizen_Invite_'.$player->getID();
		
		if (!$npc->hasTemp($key2))
		{
			$npc->setTemp($key2, rand(1,4));
		}
		
		$key = $npc->getTemp($key2);
		
		$npc->reply($this->lang('i_'.$key));
		
		if ($key == 4)
		{
			$this->onInviteCitizen($npc, $player, $npc->getParty()->getMemberCount());
			$npc->setTemp($key2, 5);
		}
		
		return true;
		
// 		switch ($key)
// 		{
// 			case 1: $npc->reply('Yeah, I am already invited. Thanks.'); break;
// 			case 2: $npc->reply('No, I am not interested.'); break;
// 			case 3: $npc->reply('Better get a job, chummer'); break;
			
// 			case 1: case 2: case 3: case 5:
// 				return $npc->reply($this->lang('i_'.$key));
			
// 			case 4:
// 				$npc->reply('An invitation for a big party? Sure me and my friends are in. Thank you!');
// 				$this->onInviteCitizen($npc, $player, $npc->getParty()->getMemberCount());
// 				$npc->setTemp($key2, 5);
// 				break;

// 			case 5:
// 				$npc->reply('See you there!');
// 				break;
// 		}
	}
}
?>