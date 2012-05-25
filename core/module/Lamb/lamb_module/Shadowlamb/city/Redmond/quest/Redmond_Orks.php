<?php
final class Quest_Redmond_Orks extends SR_Quest
{
// 	public function getQuestName() { return 'TheBracelett'; }
// 	public function getQuestDescription() { return 'Deliver the Bracelett to Reginald, the guest in the Trolls\' Inn.'; }
	public function getRewardXP() { return 10; }
	public function getRewardNuyen() { return 1000; }
	public function onQuestSolve(SR_Player $player)
	{
		$xp = $this->getRewardXP();
		$nuyen = $this->getRewardNuyen();
		$player->message($this->lang('reward', array(Shadowfunc::displayNuyen($nuyen), $xp)));
// 		$player->message(sprintf('You hand Reginald his wifes bracelett. He cheers and hands you %s. You also gained %dXP.', Shadowfunc::displayNuyen($nuyen), $xp));
// 		$player->giveNuyen($nuyen);
// 		$player->giveXP($xp);
	}
}
?>