<?php
class Quest_Chicago_RazorBaarkeeper1 extends SR_Quest
{
	public function getQuestName() { return 'Bummer'; }
	public function getNeededAmount() { return 20; }
	public function getQuestDescription() { return sprintf('Kill %d/%d bums and report your heroic feat to The Razor Barkeeper, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 5000; }
	
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$dp = $this->displayRewardNuyen();
	
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("Haha ... you want to be a runner ... kill 20 bums and i reward your with {$dp}.");
				break;
			case 'confirm':
				$npc->reply("So?");
				break;
			case 'yes':
				$npc->reply('I was just kidding!');
				break;
			case 'no':
				$npc->reply('Hehe yeah, i was just kidding.');
				break;
		}
		return true;
	}
	
}

# Compensate for spelling mistake as long as db contains the misspelled name
final class Quest_Chicago_RazorBarkeeper1 extends Quest_Chicago_RazorBaarkeeper1
{
}
?>
