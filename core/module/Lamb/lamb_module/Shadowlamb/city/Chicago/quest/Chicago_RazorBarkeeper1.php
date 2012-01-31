<?php
final class Quest_Chicago_RazorBarkeeper1 extends SR_Quest
{
	public function getQuestName() { return 'Bummer'; }
	public function getNeededAmount() { return 20; }
	public function getQuestDescription() { return sprintf('Kill %d/%d bums and report your heroic feat to The Razor Barkeeper, Chicago.', $this->getAmount(), $this->getNeededAmount()); }
	public function getRewardXP() { return 2; }
	public function getRewardNuyen() { return 5000; }
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		if ($this->getAmount() >= $this->getNeededAmount())
		{
			$npc->reply('Dude i was just kidding ... well ... here you are -.-');
			$this->onSolve($player);
		}
		else
		{
			$npc->reply('Dude i was just kidding -.-');
		}
		return false;
	}
	
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
				if ( (count($args) === 0) || ($args[0] !== 'SURE') )
				{
					$player->message("Use \X02#talk no SURE\X02 to decline this quest forever.");
				}
				else
				{
					$this->decline($player);
				}
				break;
		}
		return true;
	}
}
?>
