<?php
final class Quest_Seattle_BD4 extends SR_Quest
{
	const REWARD_XP = 8;
	const REWARD_NUYEN = 2000;

	public function getNeededAmount() { return 7; }
	
// 	public function getQuestName() { return 'PoorSmithRevenge'; }
// 	public function getQuestDescription() { return sprintf('Bring %s/%s Tenugui to the Seattle Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return false;
		}
		
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		$have = $this->giveQuesties($player, $npc, 'Tenugui', $have, $need);
		$this->saveAmount($have);
		if ($have >= $need)
		{
			$ny = Shadowfunc::displayNuyen(self::REWARD_NUYEN);
			$xp = self::REWARD_XP;
			
			$npc->reply($this->lang('thx1'));
			$npc->reply($this->lang('thx2', array($ny)));
			$player->message($this->lang('thx3', array($ny, $xp)));
			
// 			$npc->reply('Haha, great! You are the best. This might have been a lesson for them.');
// 			$npc->reply(sprintf('I am still a bit short on money. But you can have %s.', $ny));
// 			$player->message(sprintf('The smith hands you %s. You also gain %s XP.', $ny, $xp));
			
			$player->giveNuyen(self::REWARD_NUYEN);
			$player->giveXP($xp);
			$this->onSolve($player);

			$npc->reply($this->lang('thx4'));
// 			$npc->reply('You know what ... I will teach you how to use lockpicking.');
			
			$player->alterField('lockpicking', 1);
			
			$player->message($this->lang('thx5'));
// 			$player->message(sprintf('Your lockpicking skill has increased by 1.'));
		}
		else
		{
			$npc->reply($this->lang('more', array($need-$have)));
// 			$npc->reply(sprintf('Please bring me another %d Tenugui. I will reward you well.', $need-$have));
		}
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply('I promise I will reward you well this time. Ok?');
				break;
			case 'shadowrun':
				$npc->reply($this->lang('shadowrun1'));
				$npc->reply($this->lang('shadowrun2', array($this->getNeededAmount())));
				$npc->reply($this->lang('shadowrun3'));
// 				$npc->reply('Thanks to you I am back in business.');
// 				$npc->reply('If you really want a run, go kill all those Ninjas who robbed me and get me '.$this->getNeededAmount().' Tenugui.');
// 				$npc->reply('I promise I will reward you well this time. Ok?');
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply(sprintf('Yay! I await you back!'));
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Anyway check out my offers!');
				break;
		}
		return true;
	}
}
?>
