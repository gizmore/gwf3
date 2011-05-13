<?php
final class Quest_Redmond_Punks extends SR_Quest
{
	public function getQuestDescription() { return sprintf('Kill %s/%s Punks and return to the HellsPub', $this->getAmount(), $this->getNeededAmount()); }
	public function getNeededAmount() { return 10; }
	public function onKilledPunk(SR_Player $player)
	{
		$this->increase('sr4qu_amount', 1);
		$player->message(sprintf('Now you have killed %d of %d Punks for the HellPub quest.', $this->getAmount(), $this->getNeededAmount()));
	}
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		if ($have >= $need) {
			$this->onSolve($player);
		} else {
			$npc->reply(sprintf('Our informants reported you have killed %d of %d punks yet... Kill some more!', $have, $need));
		}
	}
	public function onQuestSolve(SR_Player $player)
	{
		$player->message('The biker cheers: "Here chummer, you may now wear our jacket." - He hands you a biker jacket and 150 nuyen. You also gained 2 XP.');
		$player->giveNuyen(150);
		$player->giveXP(2);
		$player->giveItems(SR_Item::createByName('BikerJacket'));
	}
}
?>