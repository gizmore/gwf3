<?php
final class Quest_Chicago_OwlJohnson1 extends SR_Quest
{
	public function getQuestName() { return 'Taped'; }
	public function getNeededAmount() { return 1; }
	public function getQuestDescription() { return sprintf('Bring a copy of the latest NySoft backups to Mr.Johnson in the OwlsClub, Chicago.'); }
	public function getRewardXP() { return 8; }
	public function getRewardNuyen() { return 4000; }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'NySoftBackup', $have_before, $need);
		
		if ($have > $have_before)
		{
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Impressive, you are of great value for the movement.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('Sup chipper?', $need-$have));
		}
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("We need *cough* NySoftBackup *cough*.");
				break;
			case 'confirm':
				$npc->reply("*cough* NySoftBackup *cough*");
				break;
			case 'yes':
				$npc->reply('*cough* laters chummer *cough*.');
				break;
			case 'no':
				$npc->reply('Laters. *cough*');
				break;
		}
		return true;
	}
}
?>