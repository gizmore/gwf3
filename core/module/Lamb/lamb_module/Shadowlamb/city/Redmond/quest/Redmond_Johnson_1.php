<?php
final class Quest_Redmond_Johnson_1 extends SR_Quest
{
	public function getRewardNuyen() { return 350; }
	public function getRewardXP() { return 3; }
// 	public function getQuestName() { return 'Lame'; }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
// 	public function getQuestDescription() { return sprintf('Kill %s/%s Lamers and return to Mr.Johnson in the Redmond\'s Trolls\' Inn.', $this->getAmount(), $this->getNeededAmount()); }
	public function getNeededAmount() { return 10; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$amt = $this->getAmount();
		$max = $this->getNeededAmount();
		$need = $max - $amt;
		if ($need <= 0)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply($this->lang('more', array($amt, $max, $need)));
// 			$npc->reply(sprintf('My informants told me you killed %d of %d lamers so far. Now go and kill %d more, chummer.', $amt, $max, $need));
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$ny = $this->getRewardNuyen();
		$xp = $this->getRewardXP();
		$player->message($this->lang('reward1'));
		$player->message($this->lang('reward2', array(Shadowfunc::displayNuyen($ny), $xp)));
// 		$player->message('Mr.Johnson looks pleased. "Well done", he says. As a reward take this...');
// 		$player->message(sprintf('Mr.Johnson hands you %s. You also gained %d XP.', Shadowfunc::displayNuyen($ny), $xp));
	}
}
?>