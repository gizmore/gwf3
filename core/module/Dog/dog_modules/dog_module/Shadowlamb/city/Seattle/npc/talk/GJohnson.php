<?php
final class Seattle_GJohnson extends SR_TalkingNPC
{
	public function getName() { return 'Mr.Johnson'; }
	public function getNPCQuests(SR_Player $player) { return array('Seattle_GJohnson1','Seattle_GJohnson2','Seattle_GJohnson3','Seattle_GJohnson4'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === SR_Quest::getQuest($player, 'Chicago_OwlJohnsonRoundtrip')->onRoundtripShow($player, $this))
		{
			return true;
		}
		
// 		$b = chr(2);
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'bounty':
				if ($this->onNPCBountyTalk($player, $word, $args))
				{
					return true;
				}
				return $this->rply('bounty');
// 				return $this->reply('Yeah, become a bountyhunter!');
			
			case 'malois':
				return $this->rply('malois');
// 				return $this->reply('I am very busy this evening.');
				
			default:
				$this->rply('default');
// 				$this->reply("Hello chummer. Looking for a job? Maybe you wanna become a {$b}bounty{$b}hunter");
				$player->giveKnowledge('words', 'Bounty');
				return true;
		}
		
	}
}
?>