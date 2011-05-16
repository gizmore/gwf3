<?php
final class Quest_Seattle_Library2 extends SR_Quest
{
	public function getNeededAmount() { return 5; }
	public function getQuestDescription() { return sprintf('Bring %s/%s bacon to the gnome in the Seattle Library', $this->getAmount(), $this->getNeededAmount()); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Bacon', $have, $need);
		if ($have >= $need)
		{
			$npc->reply('MMmm bacon ... my favorite snack. How did you know?');
			$player->message('The gnome returns to work.');
			$this->onSolve($player);
		}
	}
}
?>