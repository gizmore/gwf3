<?php
final class Redmond_AresDwarf_II extends SR_TalkingNPC
{
	public function getName() { return 'Brog'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest2 = SR_Quest::getQuest($player, 'Redmond_AresDwarf_II');
		$done2 = $quest2->isDone($player);
		$has2 = $quest2->isInQuest($player);
		$num = $quest2->getNeededAmount();
		
		if ($player->hasTemp('Redmond_AresDwarf_II_sr'))
		{
			if ($word === 'yes')
			{
				$this->rply('accept');
// 				$this->reply('Good luck while punish them! *mwahaha*');
				$quest2->accept($player);
				$player->unsetTemp('Redmond_AresDwarf_II_sr');
				return;
			}
			if ($word === 'no')
			{
				$player->unsetTemp('Redmond_AresDwarf_II_sr');
				$this->rply('decline');
// 				$this->reply('Too bad. If you change your mind let me know.');
				return;
			}
		}
		
		if ($word === 'shadowrun')
		{
			if ($has2 || $done2) {
				$this->checkQuest2($player, $quest2);
			}
			elseif ($player->hasTemp('Redmond_AresDwarf_II_sr')) {
				$this->rply('confirm');
// 				$this->reply('Do you accept the quest, chummer?');
			}
			else {
				$this->rply('descr1');
				$this->rply('descr2');
				$this->rply('descr3', array($num));
// 				$this->reply('You are looking for a job, chummer?');
// 				$this->reply('As you might know we regulary get robbed by the cyberpunks.');
// 				$this->reply("It is payback time! Bring me $num Cyberpunk Scalps and I will happliy reward you. What do you say?");
				$player->setTemp('Redmond_AresDwarf_II_sr', true);
			}
		}
		
		else
		{
			if ($has2 === true) {
				$this->checkQuest2($player, $quest2);
			}
			elseif ($word === 'yes' || $word === 'no') {
				$this->rply('default2');
// 				$this->reply('We have the finest weapons and utilities. Low prices and high damage =)');
			}
			else {
				$this->rply('default1');
// 				$this->reply("Hello my friend, are you interested in our fine armoury?");
			} 
		}
		return true;
	}
	
	private function checkQuest2(SR_Player $player, Quest_Redmond_AresDwarf_II $quest2)
	{
		if ($quest2->isDone($player))
		{
			return $this->rply('thx');
// 			return $this->reply('Thank you for your help.');
		}
		
		$have = $quest2->getAmount();
		$need = $quest2->getNeededAmount();
		$have = $quest2->giveQuesties($player, $this, 'PunkScalp', $have, $need, true);
		
		if ($have >= $need)
		{
			$quest2->onSolve($player);
		}
		else
		{
			$this->rply('more', array($need-$have));
// 			$this->reply(sprintf('Could you please bring me %d more scalps?', $need));
		}
		return true;
	}
	
}
?>