<?php
final class Quest_Redmond_Blacksmith extends SR_Quest
{
	public function getQuestName() { return 'Smithing'; }
	public function getQuestDescription() { return 'Bring a SmithHammer to the Redmond Blacksmith, so you can runecraft your equipment.'; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (1 === $this->giveQuesties($player, $npc, 'SmithHammer', 0, 1))
		{
			$this->onSolve($player);
		}
		else
		{
			$npc->rply('aww2');
// 			$npc->reply('Oh I already see you don`t have the SmithHammer for me... I hope you can get it soon.');
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$this->msg('solve1');
		$this->msg('solve2');
// 		$player->message('The dwarf cheers: "Thank you very much. Now I can get back to work!"');
// 		$player->message('"Take this as a special reward", the dwarf says. (He hands you 200 nuyen)');
		$player->giveNuyen(200);
	}
	
}
?>