<?php
final class Seattle_BMGuy extends SR_TalkingNPC
{
	public function getName() { return 'Mogrid'; }
	public function getNPCLevel() { return 9; }
	public function getNPCPlayerName() { return 'Mogrid'; }
	public function getNPCMeetPercent(SR_Party $party) { return 0.00; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Fichetti',
			'armor' => 'KevlarVest',
			'legs' => 'Trousers',
			'boots' => 'LeatherBoots',
		);
	}
	public function getNPCInventory() { return array('SmallFirstAid','Ammo_5mm','Ammo_5mm','Ammo_5mm','Ammo_5mm','Ammo_5mm'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 4),
			'quickness' => rand(2, 4),
			'distance' => rand(0, 2),
			'pistols' => rand(1, 2),
			'firearms' => rand(2, 3),
			'sharpshooter' => rand(0, 1),
			'nuyen' => rand(20, 40),
			'base_hp' => 14,
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Johnson3');
		
		switch ($word)
		{
			case 'shadowrun':
				if ($quest->isInQuest($player))
				{
					$this->reply('What? You want money for Mr.Johnson?! ... ');
					$this->reply('Well ... Give him that from me:');
					SR_NPC::createEnemyParty('Seattle_BMGuy')->fight($player->getParty(), true);
					return true;
				}
				else
				{
					return $this->reply('Yeah, I have heard from you. I have nothing todo though.');
				}

			case 'magic': return $this->reply('There is no magic in a good weapon.'); break;
			case 'renraku': return $this->reply('You don\'t have trouble with renraku, do you?'); break;
			case 'blackmarket': return $this->reply('I\'d call it graymarket.'); break;
				
			case 'negotiation': return $this->reply('Yes, all want to negotiate nowadays.');
			
			case 'malois':
			case 'yes':
			case 'no':
			case 'fakeid':
				return $this->bmguyFakesID($player, $word);
				
			default: return $this->reply('Come buy hot stuff!');
		}
	}

	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Johnson3');
		return $quest->dropCollar($this, $player);
	}
	
	public function bmguyFakesID(SR_Player $player, $word)
	{
		$price = 6000;
		$price = Shadowfunc::calcBuyPrice($price, $player);
		
		$tmp1 = '_BMGMQ_F'; # fake
		$tmp2 = '_BMGMQ_M'; # malo
		$tmp3 = '_BMGMQ_A'; # acpt
		
		$is_poor = $player->getNuyen() < $price;
		
		switch ($word)
		{
			case 'yes':
				
				if ($player->hasTemp($tmp1))
				{
					$player->unsetTemp($tmp1);
					$player->setTemp($tmp2, 1);
					return $this->reply('LOL ok ... who you are gonna be today?');
				}
				
				elseif ($player->hasTemp($tmp3))
				{
					$player->unsetTemp($tmp3);
					if ($is_poor)
					{
						return $this->reply('Are you kidding me ... you didn\'t get the money!');
					}
					else
					{
						$player->giveNuyen(-$price);
						$player->setConst('MALOIS_ID', 1);
						return $this->reply('Ok Mr.Peltzer, here is your new ID card.');
					}
				}
				
				return $this->reply('Yes what?');
				
			case 'no':
				$player->unsetTemps(array($tmp1, $tmp2, $tmp3));
				return $this->reply('I just wanted to test you.');
				
			case 'fakeid':
				$player->unsetTemps(array($tmp2, $tmp3));
				$player->setTemp($tmp1, 1);
				return $this->reply(sprintf('You need a fake id? ... this will cost you at least %s. Do you have that much money?', Shadowfunc::displayNuyen($price)));
				
			case 'malois':
				if ($player->hasTemp($tmp2))
				{
					$player->unsetTemp($tmp2);
					$player->setTemp($tmp3, 1);
					$this->reply('A family member of Malois Peltzer? Interesting ...');
					$this->reply('I have an ID card almost ready for that ... just let me get the photo straigth...');
					return $this->reply(sprintf('Ok chummer, that will be %s. You got that?', Shadowfunc::displayNuyen($price)));
					
				}
				return $this->reply('Never heard of that guy.');
				
		}
	}
}
?>