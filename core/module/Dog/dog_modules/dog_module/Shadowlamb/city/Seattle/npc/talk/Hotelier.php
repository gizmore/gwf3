<?php
final class Seattle_Hotelier extends SR_TalkingNPC
{
	const MAX_NO = 6;
	const TEMP_WORDN = 'Seattle_Hotelier_NEGON';
	const TEMP_WORD1 = 'Seattle_Hotelier_NEGO1';
	const TEMP_WORD2 = 'Seattle_Hotelier_NEGO2';
	
// 	public function getName() { return 'The hotelier'; }
	public function getName() { return $this->langNPC('name'); }
	
	private function calcNegPrice(SR_Player $player)
	{
		$price = 10000;
		$try = $player->getTemp(self::TEMP_WORDN);
		$price -= $try * 1000;
		return $price;
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$price = 40;
		
		if ($this->checkRJ3Quest($player))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'malois': #return $this->reply('Are you a friend of Malois? He owes me money.');
			case 'renraku': #$msg = "Oh, you are here to visit the Renraku building? You better have the permission to do so."; break;
			case 'shadowrun': #$msg = "Hmm, when you look for a job, you should visit the local pubs."; break;
				return $this->rply($word);

			case 'negotiation':
			case 'nego':
				
				$this->rply('nego1');
// 				$this->reply('Negotiation. The art of getting better deals by being smart in a discussion.');
				if ($player->getBase('negotiation') < 0)
				{
					if (!$player->hasTemp(self::TEMP_WORD2))
					{
						$player->setTemp(self::TEMP_WORD1, 1);
						$player->setTemp(self::TEMP_WORDN, 1);
						$this->rply('nego2', array($this->calcNegPrice($player)));
// 						$this->reply('If you like to, I can teach it to you for ... Let\'s say '.$this->calcNegPrice($player).' Nuyen. What do you say?');
					}
				}
				return true;
				
			case 'yes':
				if ($player->hasTemp(self::TEMP_WORD2))
				{
					return $this->rply('nego3');
// 					$this->reply('Haha! No chummer you pushed too far!');
				}
				elseif ($player->hasTemp(self::TEMP_WORD1))
				{
					$back = $this->teachNego($player);
					$player->unsetTemp(self::TEMP_WORD1);
					$player->unsetTemp(self::TEMP_WORDN);
					return $back;
				}
				else
				{
					return $this->rply('yes');
// 					$this->reply('Please use #sleep to rent a room.');
				}
// 				return;
				
			case 'no':
				if ($player->hasTemp(self::TEMP_WORD2))
				{
					return $this->rply('no1');
// 					$this->reply('Ok, then not.');
				}
				elseif ($player->hasTemp(self::TEMP_WORD1))
				{
					if ($player->getTemp(self::TEMP_WORDN) >= self::MAX_NO)
					{
						$this->rply('no2');
// 						$this->reply('Ok ok ... You are the boss.');
						$player->unsetTemp(self::TEMP_WORD1);
						$player->unsetTemp(self::TEMP_WORDN);
						$player->setTemp(self::TEMP_WORD2, 1);
					}
					else
					{
						$player->increaseTemp(self::TEMP_WORDN, 1);
						$this->rply('no3', array($this->calcNegPrice($player)));
// 						$this->reply(sprintf('Hmm ok... How about %s Nuyen then?', $this->calcNegPrice($player)));
					}
				}
				else
				{
					return $this->rply('no4');
// 					$this->reply('Please come back later.');
				}
				return true;
				
			default:
				$this->rply('default', array($price));
// 				$this->reply("Hello. We offer a room to you for {$price} Nuyen per day and person, and we don't negotiate. We hope you enjoy your stay.");
				$player->giveKnowledge('words', 'Negotiation');
				return true;
		}
		
// 		$this->reply($msg);
	}

	private function teachNego(SR_Player $player)
	{
		$price = $this->calcNegPrice($player);
		$have = $player->getNuyen();
		if ($price > $have)
		{
			return $this->rply('poor', array($price, $have));
// 			$this->reply(sprintf('Chummer, I want %s but you only have %s Nuyen.', $price, $have));
// 			return;
		}
		
		$player->giveNuyen(-$price);
		$player->alterField('negotiation', 1);
		$player->modify();
		
		$player->message($this->langNPC('pay', array($price, $player->getNuyen())));
// 		$player->message(sprintf('You hand %s Nuyen to the Hotelier and he teaches you the negotiation skill. You now have %s Nuyen left.', $price, $player->getNuyen()));
		return $this->rply('paid');
// 		$this->reply('Thanks chummer. Hope it will help you on your journey.');
	}
	
	private function checkRJ3Quest($player)
	{
		$quest = SR_Quest::getQuest($player, 'Redmond_Johnson_3');
		if ($quest->isInQuest($player))
		{
			return $quest->checkQuest($this, $player);
		}
		return false;
	}
	
}
?>
