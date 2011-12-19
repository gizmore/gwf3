<?php
final class Quest_Seattle_GJohnson4 extends SR_Quest
{
	const REWARD_XP = 4;
	const REWARD_NUYEN = 2500;
	
	public function getQuestName() { return 'Hardware'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %s/%s ElectronicParts to Mr.Johnson in the Garage Pub.', $this->getAmount(), $this->getNeededAmount()); }
	
	public function giveElectronicParts(SR_Player $player)
	{
		if (!$this->isInQuest($player))
		{
			return array();
		}
		$data = $this->getQuestData();
		if (!isset($data['DROPPED']))
		{
			$data['DROPPED'] = 0;
		}
		
		if ($data['DROPPED'] >= $this->getNeededAmount())
		{
			return array();
		}
		
		$data['DROPPED']++;
		$this->saveQuestData($data);
		
		return array(SR_Item::createByName('ElectronicParts'));
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		$have = $this->giveQuesties($player, $npc, 'ElectronicParts', $have, $need);
		$this->saveAmount($have);
		
		if ($have >= $need)
		{
			$npc->reply('Good job, chummer. Here is your reward.');
			$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
			$xp = self::REWARD_XP;
			$player->message(sprintf('Mr.Johnson hands you a couvert with %s. You also gain %s XP.', $ny, $xp));
			$player->giveNuyen(self::REWARD_NUYEN);
			$player->giveXP(self::REWARD_XP);
			$this->onSolve($player);
			return true;
		}
		else
		{
			$npc->reply(sprintf('You brought me %s of %s ElectronicParts. Please bring %s more.', $have, $need, $need-$have));
			return true;
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply('Yo chummer, I have another important mission for you.');
				$npc->reply('A contractor needs to get some ElectronicParts stolen from a ship delivery in the harbor.)');
				$npc->reply(sprintf('You would need to bring me %s ElectronicParts to get the job done. What do you say?', $this->getNeededAmount()));
				break;
			
			case 'confirm':
				$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
				$npc->reply(sprintf('I will pay you %s for this run.', $ny));
				break;
				
			case 'yes':
				$npc->reply(sprintf('See you around, chummer.'));
				break;
				
			case 'no':
				$npc->reply(sprintf('See you around, chummer.'));
				break;
		}
		return true;
	}
}
?>
