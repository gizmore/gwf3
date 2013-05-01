<?php
final class Quest_Seattle_GJohnson2 extends SR_Quest
{
	const REWARD_XP = 5;
	const REWARD_NUYEN = 1500;
	
	public function getNeededAmount() { return 10; }
	
// 	public function getQuestName() { return 'TheSameContractor'; }
// 	public function getQuestDescription() { return sprintf('Bring %s/%s IDCards to Mr.Johnson in the Garage Pub.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
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
			$npc->reply($this->lang('thx1'));
// 			$npc->reply('Good job, chummer. Here is your reward.');
			$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
			$xp = self::REWARD_XP;
			$player->message($this->lang('thx2', array($ny, $xp)));
// 			$player->message(sprintf('Mr.Johnson hands you a couvert with %s. You also gain %s XP.', $ny, $xp));
			$player->giveNuyen(self::REWARD_NUYEN);
			$player->giveXP(self::REWARD_XP);
			$this->onSolve($player);
			return true;
		}
		else
		{
			$npc->reply($this->lang('more', array($have, $need, $need-$have)));
// 			$npc->reply(sprintf('You brought me %s of %s IDCards. Please bring %s more.', $have, $need, $need-$have));
			return true;
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				$npc->reply($this->lang('sr3', array($this->getNeededAmount(), $ny)));
				$npc->reply($this->lang('sr4'));
// 				$npc->reply('Yo chummer, I have an important application from a big contractor.');
// 				$npc->reply('The Renraku coorparation got a security breach and needs to collect their stolen IDCards ... "lol" right?');
// 				$npc->reply(sprintf('Please bring me %s IDCards and I will pay you %s.', $this->getNeededAmount(), $ny));
// 				$npc->reply('Do you accept?');
				break;
			
			case 'confirm':
				$npc->reply($this->lang('confirm', array($ny)));
// 				$npc->reply(sprintf('I will pay you %s for this run.', $ny));
				break;
				
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply(sprintf('See you around, chummer.'));
				break;
				
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply(sprintf('See you around, chummer.'));
				break;
		}
		return true;
	}
	
}
?>
