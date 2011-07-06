<?php
final class Quest_Seattle_IDS extends SR_Quest
{
	public function getQuestName() { return 'Malois'; }
	public function getQuestDescription() { return 'Bring 3 Renraku ID Cards to the Elve in the Deckers Pub.'; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (false == ($cards = $player->getInvItemByName('IDCard'))) {
			return;
		}
		if ($cards->getAmount() < 3) {
			return;
		}
		$cards->useAmount($player, 3);
		$player->message('You hand 3 IDCards to Malois.');
		$npc->reply('Thank you very much. Now we sneak into Renraku and find out what they did to us.');
		$npc->reply('By the way... I remember you from the experiments there...');
		$this->onSolve($player);
	}
	
	public function onQuestSolve(SR_Player $player)
	{
		$nuyen = 750;
		$player->message('Malois sneakily hands you '.$nuyen.' Nuyen and a piece of paper.');
		$player->giveNuyen($nuyen);
		$note = SR_Item::createByName('Note');
		$player->giveItems(array($note));
	}
}
?>