<?php
final class Quest_Redmond_AresDwarf_I extends SR_Quest
{
// 	public function getQuestName() { return 'Kniffle'; }
// 	public function getQuestDescription() { return sprintf('Bring %d/%d knifes to the Redmond_Ares.', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getNeededAmount() { return 4; }
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 330; }
	public function onQuestSolve(SR_Player $player)
	{
		$xp = $this->getRewardXP();
		$ny = $this->getRewardNuyen();
		$player->message($this->lang('solved', array(Shadowfunc::displayNuyen($ny), $xp)));
// 		$player->message(sprintf('The dwarf cheers and hands you %s. You also gained %s XP.', Shadowfunc::displayNuyen($ny), $xp));
// 		$player->giveXP($xp);
// 		$player->giveNuyen($ny);
		
		$quest2 = SR_Quest::getQuest($player, 'Redmond_AresDwarf_II');
		$quest2 instanceof Quest_Redmond_AresDwarf_II;
		if ($quest2->isDone($player))
		{
			$quest2->onSolveDuo($player);
		}
	}
} 
?>