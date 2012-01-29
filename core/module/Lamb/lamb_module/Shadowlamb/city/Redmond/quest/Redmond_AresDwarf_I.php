<?php
final class Quest_Redmond_AresDwarf_I extends SR_Quest
{
	public function getQuestName() { return 'Kniffle'; }
	public function getQuestDescription() { return sprintf('Bring %d/%d knifes to the Redmond_Ares.', $this->getAmount(), $this->getNeededAmount()); }
	public function getNeededAmount() { return 4; }
	public function onQuestSolve(SR_Player $player)
	{
		$xp = 3;
		$ny = 330;
		$player->message(sprintf('The dwarf cheers and hands you %s. You also gained %s XP.', Shadowfunc::displayNuyen($ny), $xp));
		$player->giveXP($xp);
		$player->giveNuyen($ny);
		
		$quest = SR_Quest::getQuest($player, 'Redmond_AresDwarf_II');
		if ($quest->isDone($player)) {
			$quest->onSolveDuo($player);
		}
	}
} 
?>