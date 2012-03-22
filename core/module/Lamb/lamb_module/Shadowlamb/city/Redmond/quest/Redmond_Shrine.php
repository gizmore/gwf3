<?php
final class Quest_Redmond_Shrine extends SR_Quest
{
	public function getQuestName() { return $this->lang('title'); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getNeededAmount() { return 3; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$need = $this->getNeededAmount();
		$have = $this->getAmount();
		$have = $this->giveQuesties($player, $npc, 'WoodNunchaku', $have, $need);
		
		$this->saveVar('sr4qu_amount', $have);
		
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$player->message($this->lang('more', array($need-$have)));
// 			$player->message(sprintf('Hello my friend. Please bring us %d more WoodNunchaku.', $need-$have));
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$player->message($this->lang('impressed'));
// 		$player->message("The monk smiles. I am very impressed my $son. May the spirit of Buddah guide your path...");
		
		if ($player->hasSkill('searching'))
		{
			$player->message($this->lang('strong'));
// 			$player->message('The monk says: "You are really strong my '.$son.', please take this donation as a sign of deep respect to your greatful skills and patience."');
			$player->giveNuyen(300);
			$player->message($this->lang('nyward', array(300)));
// 			$player->message('You received a donation of 300 nuyen.');
		}
		else
		{
			$player->message($this->lang('reward1'));
// 			$player->message('The monk says: "I will now teach you a real skill, the skill of seeing the invisible and finding the hidden paths."');
			$player->updateField('searching', 0);
			$skillname = Shadowfunc::translateVariable($player, 'searching');
			$player->message($this->lang('reward2', array($skillname)));
// 			$player->message('You have learned the skill "searching".');
		}
	}
}
?>