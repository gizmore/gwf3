<?php
final class Quest_Redmond_Orks extends SR_Quest
{
	public function getQuestDescription() { return 'Deliver the Bracelett to Reginald, the guest in the TrollsInn.'; }
	public function onQuestSolve(SR_Player $player)
	{
		$xp = 10;
		$nuyen = 1000;
		$player->message(sprintf('You hand Reginald his wifes bracelett. He cheers and hands you %s. You also gained %dXP.', Shadowfunc::displayPrice($nuyen), $xp));
		$player->giveNuyen($nuyen);
		$player->giveXP($xp);
	}
}
?>