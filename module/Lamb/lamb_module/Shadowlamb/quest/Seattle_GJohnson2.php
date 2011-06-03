<?php
final class Quest_Seattle_GJohnson2 extends SR_Quest
{
	const REWARD_XP = 5;
	const REWARD_NUYEN = 1500;
	
	public function getQuestName() { return 'TheSameContractor'; }
	public function getNeededAmount() { return 10; }
	public function getQuestDescription() { return sprintf('Bring %s/%s IDCards to Mr.Johnson in the Garage Pub.', $this->getAmount(), $this->getNeededAmount()); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		
		$have = $this->giveQuesties($player, $npc, 'IDCard', $have, $need);
		$this->saveAmount($have);
		
		if ($have >= $need)
		{
			$npc->reply('Good job, chummer. Here is your reward.');
			$ny = Shadowfunc::displayPrice(self::REWARD_NUYEN);
			$xp = self::REWARD_XP;
			$player->message(sprintf('Mr.Johnson hands you a couvert with %s. You also gain %s XP.', $ny, $xp));
			$player->giveNuyen(self::REWARD_NUYEN);
			$player->giveXP(self::REWARD_XP);
			$this->onSolve($player);
			return true;
		}
		else
		{
			$npc->reply(sprintf('You brought me %s of %s IDCards. Please bring %s more.', $have, $need, $need-$have));
			return true;
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply('Yo chummer, i have an important application from a big contractor.');
				$npc->reply('The Renraku coorparation got a security breach and needs to collect their stolen IDCards ... Funny :)');
				$ny = Shadowfunc::displayPrice(self::REWARD_NUYEN);
				$npc->reply(sprintf('Please bring me %s IDCards and i will pay you %s.', $this->getNeededAmount(), $ny));
				$npc->reply('Do you accept?');
				break;
			
			case 'confirm':
				$ny = Shadowfunc::displayPrice(self::REWARD_NUYEN);
				$npc->reply(sprintf('I will pay you %s for this run.', $ny));
				break;
				
			case 'yes':
				$npc->reply(sprintf('See you around, chummer.'));
				break;
				
			case 'no':
				$npc->reply(sprintf('See you around, chummer.'));
				break;
		}
	}
	
}
?>
