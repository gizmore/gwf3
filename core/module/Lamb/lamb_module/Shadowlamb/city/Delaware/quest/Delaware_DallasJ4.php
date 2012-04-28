<?php
final class Quest_Delaware_DallasJ4 extends SR_Quest
{
// 	public function getQuestName() { return 'Disquette'; }
// 	public function getQuestDescription() { return sprintf('Steal the file "results2.dbm" from the Renraku office in Seattle and bring it to Mr.Johnson in the Delaware_Dallas.'); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 1000; }
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		if ($have >= $need)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('The client will be very happy. Good job.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more'));
// 			return $npc->reply("Please bring us the data.");
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I have a client but he cannot pay much.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply("Also the run is very difficult, but you might be interested.");
				$npc->reply($this->lang('sr3'));
// 				$npc->reply("The client wants the copy of a certain file from the Renraku database.");
				$npc->reply($this->lang('sr4'));
// 				$npc->reply("The file is named \"results2.dbm\". I think you might be interested in a copy as well.");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm', array($this->displayRewardNuyen())));
// 				$npc->reply(sprintf("What do you think? I can pay you %s.", $this->displayRewardNuyen()));
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Very good.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('No?');
				break;
		}
		return true;
	}
	
	public function onGetFile($player)
	{
		return $this->saveAmount($this->getNeededAmount());
	}
}
?>
