<?php
final class Quest_Vegas_Voices extends SR_Quest
{
	public function getQuestName() { return $this->lang('title'); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getNeededAmount() { return 20; }
	
	public function getRewardNuyen() { return 800; }
	public function getRewardXP() { return 16; }
	
	public function onTryInvite(SR_NPC $npc, SR_Player $player)
	{
		if (!$this->isInQuest($player))
		{
			return $npc->reply($this->lang('no_quest_'.$npc->getGender()));
		}
		
		if ($npc->getGender() === 'male')
		{
			return $npc->reply($this->lang('oops_male'));
		}
		
		$key2 = 'Vegas_Citizen_Invite_'.$player->getID();
		
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
		
	}
	
	private function onInviteCitizen(SR_NPC $npc, SR_Player $player)
	{
		$this->increaseAmount(1);
		return $player->message($this->lang('invited', array($this->getAmount(), $this->getNeededAmount())));
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->rply($this->lang('sr1'));
				$npc->rply($this->lang('sr2'));
				$npc->rply($this->lang('sr3', array($this->getNeededAmount())));
				break;
			case 'confirm':
				$npc->rply($this->lang('confirm'));
				break;
			case 'yes':
				$npc->rply($this->lang('yes'));
				break;
			case 'no':
				$npc->rply($this->lang('no'));
				break;
		}
		return true;
	}
}
?>
