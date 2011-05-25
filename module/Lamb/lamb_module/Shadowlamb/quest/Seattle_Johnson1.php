<?php
final class Quest_Seattle_Johnson1 extends SR_Quest
{
	public function getNeededAmount() { return 15; }
	public function getQuestDescription() { return sprintf('Kill %s/%s TrollDeckers and return to Mr.Johnson in the Deckers Pub.', $this->getAmount(), $this->getNeededAmount()); }
	
	public function getQuestName() { return 'TheContractor'; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		if ($have >= $need)
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->reply(sprintf('My informants told me you only killed %s of %s TrollDeckers.', $have, $need));
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$nuyen = 1000;
		$xp = 5;
		$player->message(sprintf('Mr.Johnson looks not really happy...'));
		$player->message(sprintf('"Here chummer, take this as reward.", Mr.Johnson says, "But our client did a mistake when ordering my service...".'));
		$player->message(sprintf('He hands you %s Nuyen and you also gain %s XP.', $nuyen, $xp));
		$player->giveNuyen($nuyen);
		$player->giveXP($xp);
	}
}
?>