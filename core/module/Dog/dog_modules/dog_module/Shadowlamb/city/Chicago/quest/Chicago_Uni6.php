<?php
require_once Shadowrun4::getShadowDir().'city/Delaware/quest/Delaware_Exams5.php';
final class Quest_Chicago_Uni6 extends Quest_Delaware_Exams5
{
	public function getQuestName() { return 'MasterBachelor'; }
	public function getNeededAmount() { return 3; }
	public function getQuestDescription() { return sprintf('Bring %d/%d fluid Auris to the Chicago University Gnome.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 300; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (false === ($auris = $player->getInvItemByName('Auris')))
		{
			return $npc->reply('Oh, you don\'t have more Auris for me?');
		}
		
		if (!$this->rightInTime($player))
		{
			return $npc->reply('You got the Auris? :) ... Oh, it turned to stone already :(');
		}
		
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Auris', $have_before, $need);

		
		if ($have > $have_before)
		{
			$npc->reply('Thank you a lot, chummer.');
			$this->saveAmount($have);
		}
		
		if ($have >= $need)
		{
			$npc->reply('Wow ... You really earned a great reward now ... I will take my time and teach you the teleportiii spell!');
			$player->levelupSpell('teleportiii');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('I still need %d fluid Auris for my experiments.', $need-$have));
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
// 		$need = $this->getNeededAmount();
// 		$ny = $this->getRewardNuyen();
// 		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Good that you ask ... you are really good in organizing stuff ... i have a last order for you ...");
				$npc->reply("I need two or three fluid auris. Can you bring them to me?");
				$npc->reply("I will reward you greatly!");
				break;
			case 'confirm':
				$npc->reply("Don't worry if you say no.");
				break;
			case 'yes':
				$npc->reply('Heh ... alright then!');
				break;
			case 'no':
				$npc->reply('Ok');
				break;
		}
		return true;
	}
}
?>