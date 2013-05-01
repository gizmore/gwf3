<?php
class Quest_Delaware_Exams5 extends SR_Quest
{
// 	public function getQuestName() { return 'ExamsFinals'; }
// 	public function getQuestDescription() { return sprintf('Bring a fluid Auris to the gnome in the Delaware_Library. You can get a pot of Auris from the gnome in the Seattle library by asking for Auris.'); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 300; }
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (false === ($auris = $player->getInvItemByName('Auris')))
		{
			return $npc->reply($this->lang('aww1'));
// 			return $npc->reply('Oh, you don\'t have an Auris for me?');
		}
		
		if (!$this->rightInTime($player))
		{
			return $npc->reply($this->lang('aww2'));
// 			return $npc->reply('You got the Auris? :) ... Oh, it turned to stone already :(');
		}
		
		$auris->useAmount($player, 1);
		
		$player->message($this->lang('hand'));
// 		$player->message('You hand the pot of fluid Auris to the gnome ...');
		
		$npc->reply($this->lang('thx1'));
// 		$npc->reply('Wow. Thank you so very very much.');
		$npc->reply($this->lang('thx2'));
// 		$npc->reply('You surely earned a special reward now ... Let me think ...');
		$npc->reply($this->lang('thx3'));
// 		$npc->reply('Right ... I will teach you the teleportii spell. It is quite powerful!');
		$player->levelupSpell('teleportii');
		$player->message($this->lang('learned'));
// 		$player->message('You learned a new spell: teleportii');
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
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("I totally need some Auris now. Can you bring it to me?");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("If you bring me some more stuff I will teach you something.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Thanks.');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Why not?');
				break;
		}
		return true;
	}
	
	public function rightInTime(SR_Player $player)
	{
		$eta = $player->getConst('__AURIS_TIMEOUT');
		$player->unsetConst('__AURIS_TIMEOUT');
		return Shadowrun4::getTime() < $eta;
	}
	
	public function resetTimer(SR_Player $player)
	{
		$time = Seattle::TIME_TO_DELAWARE + 60;
		$player->setConst('__AURIS_TIMEOUT', Shadowrun4::getTime() + $time);
		$player->message($this->lang('fluid', array(GWF_Time::humanDuration($time))));
// 		$player->message(sprintf("Your pot of Auris is fluid for %s.", GWF_Time::humanDuration($time)));
		return true;
	}
}
?>
