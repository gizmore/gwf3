<?php
final class Quest_Seattle_Library3 extends SR_Quest
{
	public function getNeededAmount() { return 2; }
	public function getQuestDescription() { return sprintf('Bring %s/%s ElvenStaffs to the gnome in the Seattle Library', $this->getAmount(), $this->getNeededAmount()); }
	public function getQuestName() { return 'Studies3Finals'; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getAmount();
		$need = $this->getNeededAmount();
		$have = $this->giveQuesties($player, $npc, 'ElvenStaff', $have, $need);
		$this->saveVar('sr4qu_amount', $have);
		
		if ($have >= $need)
		{
			$npc->reply('Thank you so much. Now I can test my spells with new powerful elven staffs.');
			$player->message('The gnome returns to work.');
//			sleep(2);
			$player->message('You tap the gnome on his shoulder and remind him of a reward...');
			$npc->reply('What? Oh yes, the magic spell. I remember now ... ');
			$player->message('The gnome teaches you a new magic spell: teleport.');
			$player->levelupSpell('teleport');
			$this->onSolve($player);
		}
	}
}
?>