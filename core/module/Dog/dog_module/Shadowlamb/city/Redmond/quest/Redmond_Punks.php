<?php
final class Quest_Redmond_Punks extends SR_Quest
{
// 	public function getQuestName() { return 'Punks!!'; }
// 	public function getQuestDescription() { return sprintf('Kill %s/%s Punks and return to the HellsPub', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getNeededAmount() { return 10; }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 400; }
	public function getRewardItems() { return array('BikerJacket'); }
	
	public function onKilledPunk(SR_Player $player)
	{
		$this->increase('sr4qu_amount', 1);
		$player->message($this->lang('onkill', array($this->getAmount(), $this->getNeededAmount())));
// 		$player->message(sprintf('Now you have killed %d of %d Punks for the HellPub quest.', $this->getAmount(), $this->getNeededAmount()));
	}
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		if ($have >= $need)
		{
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply($this->lang('reports', array($have, $need)));
// 			$npc->reply(sprintf('Our informants reported you have killed %d of %d punks yet... Kill some more!', $have, $need));
		}
	}
	public function onQuestSolve(SR_Player $player)
	{
		$player->message($this->lang('grats', array($this->getRewardNuyen(), $this->getRewardXP())));
// 		$player->message('The biker cheers: "Here chummer, you may now wear our jacket." - He hands you a biker jacket and 150 nuyen. You also gained 2 XP.');
	}
}
?>
