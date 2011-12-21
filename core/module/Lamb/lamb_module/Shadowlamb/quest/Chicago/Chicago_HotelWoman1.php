<?php
final class Quest_Chicago_HotelWoman1 extends SR_Quest
{
	public function getQuestName() { return 'Lovers'; }
// 	public function getNeededAmount() { return 0; }
	public function getQuestDescription() { return sprintf('Find out what happened to Malois and return to the woman in the Chicago Hotel.'); }
	public function getRewardXP() { return 4; }
	public function getRewardNuyen() { return 200; }
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if (!SR_PlayerVar::getVal($player, '_SLQCHW1', 0))
		{
			return $npc->reply('Nothing new? ok.');
		}
		$player->message('You tell her that husband is probably in prison...');
		$npc->reply('Oh i was afraid something happened to him ... thank you so very much ... i think i have to speak to the authorities then.');
		return $this->onSolve($player);
	}
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Oh my husband was working for Renraku, but he got lost. Maybe you have heard from him?");
				$npc->reply("He was last seen in Seattle and was not officially working for them ... so don't get into trouble.");
				$npc->reply("His name is Malois Peltzer. Can you please look for him?");
				$player->giveKnowledge('words', 'Malois');
				break;
			case 'confirm':
				$npc->reply("Can you please ask for him?");
				break;
			case 'yes':
				$npc->reply('Thank you very much.');
				break;
			case 'no':
				$npc->reply('Oh, ok.');
				break;
		}
		return true;
	}
}
?>