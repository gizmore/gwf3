<?php
final class Quest_Redmond_Ueberpunk extends SR_Quest
{
// 	public function getQuestName() { return 'Ueberpunk!!!'; }
// 	public function getQuestDescription() { return sprintf('Bring the Ueberpunk\'s head to the bikers in Redmond_HellPub.'); }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (1 === $this->giveQuesties($player, $npc, 'UeberpunkHead', 0, 1)) {
			$this->onSolve($player);
		} else {
			$npc->reply($this->lang('bringme'));
// 			$npc->reply('Bring me the head of that Ueberpunk scumbag. I will reward you well.');
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$xp = 3;
		$ny = 450;
		$player->message($this->lang('grats', array($ny, $xp)));
// 		$player->message('The biker says: "Haha chummer, good job. Take this." - He hands you '.$ny.' nuyen and a BikerHelmet. You also gained '.$xp.' XP.');
		$player->giveXP($xp);
		$player->giveNuyen($ny);
		$player->giveItems(array(SR_Item::createByName('BikerHelmet')));
	}
}
?>