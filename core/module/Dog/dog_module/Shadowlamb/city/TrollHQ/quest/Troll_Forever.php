<?php
final class Quest_Troll_Forever extends SR_Quest
{
// 	public function getQuestName() { return 'TrollForever'; }
// 	public function getQuestDescription() { return sprintf('Kill %d/%d Commandos and return to Larry, the Troll chief.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function getRewardXP() { return 9; }
	public function getRewardNuyen() { return 1500; }
	public function getNeededAmount() { return 12; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Thanks friend!');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more'));
// 			$npc->reply('You too weak?');
		}
// 		return false;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$dp = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Listen chummer, now Commando is hunts us.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply('We cannot let it happen, they disgust us. Please kill some of them!');
				$npc->reply($this->lang('sr3', array($this->getNeededAmount(), $dp)));
// 				$npc->reply(sprintf('Kill %d Commando and I pay %s.', $this->getNeededAmount(), $dp));
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("Go!");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply("Thank you!");
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('You should do it.');
				break;
		}
		return true;
	}
	
	public function onKillCommando(SR_Player $player)
	{
		if ($this->isInQuest($player))
		{
			$this->increaseAmount(1);
			$player->message($this->lang('kill', array($this->getAmount(), $this->getNeededAmount())));
// 			$player->message(sprintf('Now you killed %d/%d Commandos for Larry, the Troll chief.', $this->getAmount(), $this->getNeededAmount()));
		}
		return true;
	}
}
?>
