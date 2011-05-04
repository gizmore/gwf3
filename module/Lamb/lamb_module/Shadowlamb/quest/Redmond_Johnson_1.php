<?php
final class Quest_Redmond_Johnson_1 extends SR_Quest
{
	public function getQuestDescription() { return sprintf('Kill %s/%s Lamers and return to Mr.Johnson in the Redmond_TrollsInn.', $this->getAmount(), $this->getNeededAmount()); }
	public function getNeededAmount() { return 10; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$amt = $this->getAmount();
		$max = $this->getNeededAmount();
		$need = $max - $amt;
		if ($need <= 0) {
			$this->onSolve($player);
		} else {
			$npc->reply(sprintf('My informants told me you killed %d of %d lamers so far. Now go and kill %d more, chummer.', $amt, $max, $need));
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$ny = 350;
		$xp = 3;
		$player->message('Mr.Johnson looks pleased. "Well done", he says. As a reward take this...');
		$player->message(sprintf('Mr.Johnson hands you %s. You also gained %d XP.', Shadowfunc::displayPrice($ny), $xp));
	}
}
?>