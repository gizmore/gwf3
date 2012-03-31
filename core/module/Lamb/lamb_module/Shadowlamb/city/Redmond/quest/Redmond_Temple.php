<?php
final class Quest_Redmond_Temple extends SR_Quest
{
// 	public function getQuestName() { return 'Merchandize'; }
// 	public function getQuestDescription() { return sprintf("Tell %d/%d citizens about the awesome Temple in Redmond. Use \X02#say temple\X02 to merchandize the temple.", $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getRewardXP() { return 5; }
	public function getRewardItems() { return array('Amulet_of_max_mp:10'); }
	public function getNeededAmount() { return 25; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$npc->reply($this->lang('well_done'));
// 			$npc->reply('I see you have done a great job. Well done!');
			return $this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($this->getAmount(), $this->getNeededAmount())));
// 			$npc->reply(sprintf('I see you have told %d/%d citizens about the temple. Do some more work please.', $this->getAmount(), $this->getNeededAmount()));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('run1'));
				$npc->reply($this->lang('run2', array($need)));
// 				$npc->reply("We could need help in getting more customers here.");
// 				$npc->reply("If you could \X02#say temple\X02 to {$need} citizens i will reward you very well, ok?");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
				$npc->reply("What do you think?");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Perfect!');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Ok');
				break;
		}
		return true;
	}
	
}
?>
