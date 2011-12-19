<?php
final class Quest_Chicago_HotelWoman2 extends SR_Quest
{
	public function getQuestName() { return 'Beloveds'; }
// 	public function getNeededAmount() { return 0; }
	public function getQuestDescription() { return sprintf('Rescue Malois from Delaware_Prison.'); }
	public function getRewardXP() { return 20; }
	public function getRewardNuyen() { return 3000; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Hehe you are a real gentlemen. If you could rescue my Malois from prison, i would pay you big money. All i have.");
				break;
			case 'confirm':
				$npc->reply("I know it was just an idea.");
				break;
			case 'yes':
				$npc->reply('It was just an idea ... good luck.');
				break;
			case 'no':
				$npc->reply('It was just an idea.');
				break;
		}
		return true;
	}
}
?>