<?php
final class Quest_Seattle_Temple extends SR_Quest
{
// 	public function getQuestName() { return 'TheDarkSide'; }
// 	public function getQuestDescription() { return 'Gather 1 bad_karma and get it cleaned by the Shamane in the Seattle Temple.'; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($player->getBase('bad_karma') > 0)
		{
			$npc->reply($this->lang('thx1'));
// 			$npc->reply('Excellent ... let me try to free you from your sins ...');
			$player->message($this->lang('thx2'));
// 			$player->message('The shamane is praying and mumbling ... and you feel better!');
			$player->increaseField('bad_karma', -1);
			$npc->reply($this->lang('thx3'));
// 			$npc->reply('It seems like i get better and better doing this ... let me teach you something!');
			$player->levelupSpell('bunny', 1);
			$player->message($this->lang('thx4'));
// 			$player->message('You have learned the bunny spell, which allows you to flee from combats.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more'));
// 			return $npc->reply('You still have not enough bad karma.');
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
				$npc->reply($this->lang('sr2'));
				$npc->reply($this->lang('sr3'));
// 				$npc->reply("You want to do me a favour?");
// 				$npc->reply("I am training my skills of prayer, and need someone who will benefit from my skills.");
// 				$npc->reply("If you come to me with 1 bad karma i will clean it for free and teach you something :)");
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("I know it's a weird offer. Accept?");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Don\'t be too cruel though!');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Bye bye.');
				break;
		}
		return true;
	}
}
?>
