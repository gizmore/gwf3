<?php
final class Delaware_MCJohnson extends SR_TalkingNPC
{
	public function getName() { return 'Mr.Johnson'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_MCJohnson1','Delaware_MCJohnson2','Delaware_MCJohnson3'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === SR_Quest::getQuest($player, 'Chicago_OwlJohnsonRoundtrip')->onRoundtripShow($player, $this))
		{
			return true;
		}
		
		if ($this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		$b = chr(2);
		switch ($word)
		{
			case 'bounty':
				if ($this->onNPCBountyTalk($player, $word, $args))
				{
					return true;
				}
				return $this->reply('You want to become a bountyhunter?');
				
			case 'malois':
				$key = '_SLQCHW1';
				if (SR_PlayerVar::getVal($player, $key))
				{
					return $this->reply('This is all i know, and i shouldn\'t have told you that.');
				}
				else
				{
					$this->reply('Malois? Isn\'t that the guy who claimed to be a Renraku proband and went to prison?');
					$this->reply('Well ... that\'s probably not your business... Maybe i mean Matthew.');
					$player->message('You consider that being useful information.');
					SR_PlayerVar::setVal($player, $key, 1);
					
				}
				return $this->reply('Listen chummer, it is not your business, and i would not put my hands in corp business like Renraku');
				
			default:
				$this->reply("Yo chummer");
				return true;
		}
		
	}
}
?>
