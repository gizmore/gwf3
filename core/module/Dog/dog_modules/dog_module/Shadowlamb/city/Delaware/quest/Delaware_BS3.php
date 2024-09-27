<?php
final class Quest_Delaware_BS3 extends SR_Quest
{
// 	public function getQuestName() { return 'Runic'; }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 1200; }
	public function getNeededAmount() { return 8; }
// 	public function getQuestDescription() { return sprintf('Bring %d/%d Runes to the Delaware Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();

		$have_after = $have_before;
		foreach ($player->getInventory()->getItemsByClass('SR_Rune', $need-$have_before) as $item)
		{
			$player->deleteFromInventory($item);
			$have_after++;
			if ($have_after >= $need) {
				break;
			}
		}

		$this->saveAmount($have_after);
		if ($have_after >= $need)
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('You are the best! I will teach you something useful now :)');
			$this->onSolve($player);
			$player->saveBase('thief', 0);
			$player->modify();
			$player->message($this->lang('reward'));
// 			$player->message("You have learned the thief skill!");
			return true;
		}
		else
		{
			return $npc->reply($this->lang('more', array($need-$have_after)));
// 			return $npc->reply(sprintf("Please bring me %d more Runes. Thank you.", $need-$have_after));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Wow you must be eager to solve problems.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply("There is actually one thing you could do for me which I would really appreciate.");
				$npc->reply($this->lang('sr3', array($need)));
// 				$npc->reply("Please bring me {$need} Runes, and I will reward you greatly.");
				$npc->reply($this->lang('sr4'));
// 				$npc->reply("What do you say?");
				$player->message($this->lang('warn'));
// 				$player->message('Beware: The smith will take any runes you might carry!');
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("Do you accept the quest?");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Alright, great :)');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Oh, ok.');
				break;
		}
		return true;
	}
}
?>
