<?php
final class PrisonB2_ExitGuard extends SR_TalkingNPC
{
	public function getName() { return 'The guard'; }

	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'bribe':
				if ($this->knowsAboutMalois($player))
				{
					return $this->bribingTheGuard($player, $word, $args);					
				}
				
			default:
				return $this->reply("You are not allowed to be here. Please leave.");
		}
	}
		
	private function knowsAboutMalois(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Chicago_HotelWoman1');
		return $quest->isDone($player);
	}
	
	private function bribingTheGuard(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$price = rand(2000, 8000);
		$price = Shadowfunc::calcBuyPrice($price, $player);
		
		if (!isset($args[0]))
		{
			$this->reply('Every person has it\'s <price> parameter.');
			$player->help('Use #talk bribe <amt> to try to bribe the guard.');
			return true;
		}
		
		$amt = (int)$args[0];
		
		if ($amt < $price)
		{
			$this->reply("{$b}Security !!!!{$b}");
			$p = $player->getParty();
			$p->pushAction(SR_Party::ACTION_OUTSIDE, 'Prison_Block2');
			$ep = SR_NPC::createEnemyParty('Prison_Ward','Prison_Ward','Prison_Ward','Prison_Guard','Prison_Guard');
			$p->fight($ep, true);
		}
		else
		{
			$party = $player->getParty();
			$this->reply('Every bride has her pride ...');
			$this->reply('Ok buddy ... He is in cell 5, do quick, i will release the alarm as late as possible. Good luck ... ');
			$player->giveNuyen(-$amt);
			$party->pushAction(SR_Party::ACTION_OUTSIDE, 'PrisonB2_Exit');
		}
	}	
}
?>