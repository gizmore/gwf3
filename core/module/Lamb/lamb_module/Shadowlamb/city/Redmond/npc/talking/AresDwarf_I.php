<?php
final class Redmond_AresDwarf_I extends SR_TalkingNPC
{
	public function getName() { return 'Aron'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest1 = SR_Quest::getQuest($player, 'Redmond_AresDwarf_I');
		$num = $quest1->getNeededAmount();
		$has1 = $quest1->isInQuest($player);
		$done1 = $quest1->isDone($player);
		
		if ($player->hasTemp('Redmond_AresDwarf_I_sr'))
		{
			if ($word === 'yes')
			{
				$this->reply('Haha ok chummer... I will wait for your delivery');
				$quest1->accept($player);
				$player->unsetTemp('Redmond_AresDwarf_I_sr');
				return;
			}
			if ($word === 'no')
			{
				$player->unsetTemp('Redmond_AresDwarf_I_sr');
				$this->reply('Well, if you change your mind.. come back later.');
				return;
			}
		}
		
		if ($word === 'shadowrun')
		{
			if ($has1 || $done1) {
				$this->checkQuest1($player, $quest1);
			}
			elseif ($player->hasTemp('Redmond_AresDwarf_I_sr')) {
				$this->reply('Do you accept the quest, chummer?');
			}
			else {
				$this->reply('You are a newbie runner, eh?');
				$this->reply('Chummer... listen... we regulary get robbed by the cyberpunks.');
				$this->reply("The worst thing is they keep robbing even cheap things, like unstatted knifes. If you can help us and bring me $num unstatted knifes I would be very happy, as I plan to master the skill of knife-throwing.");
				$this->reply("You can remove stats from an item at the local blacksmith.");
				$this->reply('If you could help help us we will reward you gracefully.');
				$player->setTemp('Redmond_AresDwarf_I_sr', true);
			}
		}
		
		else
		{
			if ($has1 === true) {
				$this->checkQuest1($player, $quest1);
			}
			elseif ($word === 'yes' || $word === 'no') {
				$this->reply('We have the finest weapons and utilities. Low prices and high damage =)');
			}
			else {
				$this->reply("Hello my friend, are you interested in fine Ares armoury?");
			} 
		}
	}
	
	private function checkQuest1(SR_Player $player, SR_Quest $quest1)
	{
		if ($quest1->isDone($player)) {
			return $this->reply('We have enogh knifes now to play with. Thanks again for your help.');
		}
		
		$have = $quest1->getAmount();
		$need = $quest1->getNeededAmount() - $have;
		$give = 0;
		while ($need > 0)
		{
			if (false === ($knife = $player->getInvItemByName('Knife'))) {
				break;
			}
			if (false === $knife->deleteItem($player)) {
				break;
			}
			$give++;
			$have++;
			$need--;
		}
		
		if ($give > 0)
		{
			$this->reply(sprintf('You give %d knife(s) to the dwarf.', $give));
			$quest1->giveAmount($player, $give);
		}
		
		if (!$quest1->isDone($player))
		{
			$this->reply(sprintf('Could you please bring me %d more knifes?', $need));
		}
	}
}
?>