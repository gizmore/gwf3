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
				$this->reply('Good luck while punish them! *mwahaha*');
				$quest2->accept($player);
				$player->unsetTemp('Redmond_AresDwarf_II_sr');
				return;
			}
			if ($word === 'no')
			{
				$player->unsetTemp('Redmond_AresDwarf_II_sr');
				$this->reply('Too bad. If you change your mind let me know.');
				return;
			}
		}
		
		if ($word === 'shadowrun')
		{
			if ($has2 || $done2) {
				$this->checkQuest2($player, $quest2);
			}
			elseif ($player->hasTemp('Redmond_AresDwarf_II_sr')) {
				$this->reply('Do you accept the quest, chummer?');
			}
			else {
				$this->reply('You are looking for a job, chummer?');
				$this->reply('As you might know we regulary get robbed by the cyberpunks.');
				$this->reply("It is payback time! Bring me $num Cyberpunk Scalps and I will happliy reward you. What do you say?");
				$player->setTemp('Redmond_AresDwarf_II_sr', true);
			}
		}
		
		else
		{
			if ($has2 === true) {
				$this->checkQuest2($player, $quest2);
			}
			elseif ($word === 'yes' || $word === 'no') {
				$this->reply('We have the finest weapons and utilities. Low prices and high damage =)');
			}
			else {
				$this->reply("Hello my friend, are you interested in our fine armoury?");
			} 
		}
	}
	
	private function checkQuest2(SR_Player $player, SR_Quest $quest2)
	{
		if ($quest2->isDone($player)) {
			return $this->reply('Thank you for your help.');
		}
		
		$have = $quest2->getAmount();
		$need = $quest2->getNeededAmount() - $have;
		$give = 0;
		while ($need > 0)
		{
			if (false === ($scalps = $player->getInvItemByName('PunkScalp'))) {
				break;
			}
			
			$possible = $scalps->getAmount();
			$give = Common::clamp($possible, 0, $need);
			
			if (false === ($scalps->useAmount($player, $give))) {
				break;
			}
			$have += $give;
			$need -= $give;
		}
		
		if ($give > 0)
		{
			$this->reply(sprintf('You give %d scalp(s) to the dwarf.', $give));
			$quest2->giveAmount($player, $give);
		}
		
		if (!$quest2->isDone($player))
		{
			$this->reply(sprintf('Could you please bring me %d more scalps?', $need));
		}
	}
	
}
?>