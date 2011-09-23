<?php
final class Quest_Delaware_BS3 extends SR_Quest
{
	public function getQuestName() { return 'Runic'; }
	public function getNeededAmount() { return 8; }
	public function getQuestDescription() { return sprintf('Bring %d/%d Runes to the Delaware Blacksmith.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 6; }
	public function getRewardNuyen() { return 1200; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have_after = $this->giveQuesties($player, $npc, 'Rune', $have_before, $need);
		$this->saveAmount($have_after);
		if ($have_after >= $need)
		{
			$npc->reply('You are the best! I will teach you something useful now :)');
			$this->onSolve($player);
			$player->saveBase('thief', 0);
			$player->modify();
			$player->message("You have learned the thief skill!");
			return true;
		}
		else
		{
			return $npc->reply(sprintf("Please bring me %d more Runes. Thank you.", $need-$have_after));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Wow you must be eager to solve problems.");
				$npc->reply("There is actually one thing you could do for me which i would really appreciate.");
				$npc->reply("Please bring me {$need} Runes, and i will reward you greatly.");
				$npc->reply("What do you say?");
				$player->message('Beware: The smith will take any runes you might carry!');
				break;
			case 'confirm':
				$npc->reply("Do you accept the quest?");
				break;
			case 'yes':
				$npc->reply('Alright, great :)');
				break;
			case 'no':
				$npc->reply('Oh, ok.');
				break;
		}
		return true;
	}
	
}
?>