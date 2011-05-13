<?php
final class Quest_Seattle_Archery extends SR_Quest
{
	public function getNeededAmount() { return 20; }
	
	public function getQuestDescription() { return sprintf('Punish %s/%s Angry Elves and return to the Seattle_Archery.', $this->getAmount(), $this->getNeededAmount()); }

	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount()) {
			$this->onSolve($player);
		}
		else {
			$npc->reply(sprintf('I see you punished %s of %s Angry Elves.', $this->getAmount(), $this->getNeededAmount()));
		}
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$player->message(sprintf('The elve cheers. He thanks you and hands out a glowing dark bow.'));
		$bow = SR_Item::createByName('DarkBow');
		$mod1 = SR_Rune::randModifier($player, 10);
		$mod2 = SR_Rune::randModifier($player, 10);
		$modifiers = SR_Rune::mergeModifiers($mod1, $mod2);
		$bow->addModifiers($modifers);
		$player->giveItems($bow);
	}
}
?>