<?php
final class Quest_Delaware_DallasJ1 extends SR_Quest
{
// 	public function getQuestName() { return 'Guns'; }
// 	public function getQuestDescription() { return sprintf('Bring an AresViper11 to the Johnson in Delaware_Dallas.'); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 1000; }
	public function getNeededAmount() { return 1; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have_before = $this->getAmount();
		$need = $this->getNeededAmount();
		if (1 === $this->giveQuesties($player, $npc, 'AresViper11', $have_before, $need))
		{
			$npc->reply($this->lang('thx'));
// 			$npc->reply('Good job chummer.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('more'));
// 			return $npc->reply('Bring me the gun so I can give it to our client.');
		}
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply($this->lang('sr1'));
// 				$npc->reply("Yo chummer. A client requested to organize AresViper11 pistols.");
				$npc->reply($this->lang('sr2'));
// 				$npc->reply("There are rumors that one of them has been used in a crime scene.");
				$npc->reply($this->lang('sr3', array($this->displayRewardNuyen())));
// 				$npc->reply(sprintf("Bring me one and I will pay you %s.", $this->displayRewardNuyen()));
				break;
			case 'confirm':
				$npc->reply($this->lang('confirm'));
// 				$npc->reply("If I get one gun from some runners we should find the right gun.");
				break;
			case 'yes':
				$npc->reply($this->lang('yes'));
// 				$npc->reply('Yeah?');
				break;
			case 'no':
				$npc->reply($this->lang('no'));
// 				$npc->reply('Ok.');
				break;
		}
		return true;
	}
}
?>
