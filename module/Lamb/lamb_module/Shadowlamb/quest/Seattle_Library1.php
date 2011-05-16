<?php
final class Quest_Seattle_Library1 extends SR_Quest
{
	public function getNeededAmount() { return 500; }
	public function getQuestDescription() { return sprintf('Bring %s/%s Pringles to the gnome in the Seattle Library', $this->getAmount(), $this->getNeededAmount()); }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'Pringles', $have, $need);
		
		if ($have >= $need)
		{
			$npc->reply('Oh Pringles ... my favorite snack. How did you know?');
			$player->message('The gnome returns to work.');
			$this->onSolve($player);
		}
	}
}
?>