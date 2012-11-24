<?php
final class Quest_Seattle_GJohnson1 extends SR_Quest
{
	const REWARD_XP = 4;
	const REWARD_NUYEN = 2000;
	
	public function getNeededAmount() { return 20; }
	
// 	public function getQuestName() { return 'KillKill'; }
// 	public function getQuestDescription() { return sprintf('Kill %s/%s Killers and return to Mr.Johnson in the Garage Pub.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx1'));
// 			$npc->reply('Well done and quite fast, chummer. Here is your business.');
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
// 			$npc->reply(sprintf('It seems like you killed %s of %s killers for your run. %s to go!', $have, $need, $need-$have));
			return true;
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2', array($this->getNeededAmount())));
				$npc->reply($this->lang('sr3'));
// 				$npc->reply('Yo chummer, we need to get rid of Killers first, before we can get into business.');
// 				$npc->reply(sprintf('Please kill %s killers and come back.', $this->getNeededAmount()));
// 				$npc->reply('Do you accept?');
				break;
			
			case 'confirm':
				$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
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
