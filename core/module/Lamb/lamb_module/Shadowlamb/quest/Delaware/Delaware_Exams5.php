<?php
final class Quest_Delaware_Exams5 extends SR_Quest
{
	public function getQuestName() { return 'ExamsFinals'; }
	public function getQuestDescription() { return sprintf('Bring a fluid Auris to the gnome in the Delaware_Library. You can get a pot of Auris from the gnome in the Seattle library by asking for Auris.'); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 300; }
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (false === ($auris = $player->getInvItemByName('Auris')))
		{
			return $npc->reply('Oh, you don\'t have an Auris for me?');
		}
		
		if (!$this->rightInTime($player))
		{
			return $npc->reply('You got the Auris? :) ... Oh, it turned to stone already :(');
		}
		
		$auris->useAmount($player, 1);
		
		$player->message('You hand the pot of fluid Auris to the gnome ...');
		
		$npc->reply('Wow. Thank you so very very much.');
		$npc->reply('You surely earned a special reward now ... Let me think ...');
		$npc->reply('Right ... I will teach you the teleportii spell. It is quite powerful!');
		$player->levelupSpell('teleportii');
		$player->message('You learned a new spell: teleportii');
		$this->onSolve($player);
		return true;
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->displayRewardNuyen();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("I totally need some Auris now. Can you bring it to me?");
				break;
			case 'confirm':
				$npc->reply("If you bring me some more stuff I will teach you something.");
				break;
			case 'yes':
				$npc->reply('Please.');
				break;
			case 'no':
				$npc->reply('Why not?');
				break;
		}
		return true;
	}
	
	private function rightInTime(SR_Player $player)
	{
		$data = $this->getQuestData();
		$eta = $data['eta'];
		return Shadowrun4::getTime() < $eta;
	}
	
	public function resetTimer(SR_Player $player)
	{
		$data = $this->getQuestData();
		$time = Seattle::TIME_TO_DELAWARE + 60;
		$data['eta'] = Shadowrun4::getTime() + $time;
		$this->saveQuestData($data);
		$player->message(sprintf("Your pot of Auris is fluid for %s.", GWF_Time::humanDuration($time)));
		return true;
	}
}
?>