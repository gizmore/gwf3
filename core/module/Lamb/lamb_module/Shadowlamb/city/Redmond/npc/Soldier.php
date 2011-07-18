<?php
final class Redmond_Soldier extends SR_HireNPC
{
//	public function getName() { return $this->getPartyID() > 0 ? Shadowfunc::getRandomName($this) : 'The Soldier'; }

	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Knife',
			'armor' => 'LeatherVest',
			'legs' => 'Trousers',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(2, 3),
			'distance' => rand(0, 2),
			'nuyen' => rand(80, 120),
			'base_hp' => rand(12, 16),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$t = 'Redmond_Soldier_Hire';
		
		$price = 400 - Common::clamp($player->get('negotiation'), 0, 10) * 10;
		$time = 600 * $player->get('charisma') * 60;
		
		$b = chr(2);
		switch ($word)
		{
			case 'renraku': $msg = "I like their {$b}hardware{$b}, but they have too much influence to the market."; break;
			case 'hardware': $msg = "Yeah... hardware and stuff. You don't know Renraku? Are you a crackhead?"; break;
			case 'shadowrun': $msg = "You need to {$b}hire{$b} a runner?"; break;
			case 'gizmore': $msg = "If you are here for a special quest, i can only say i have no idea. Is there a city full of you?"; break;			
			case 'hire':
				if ($player->getTemp($t))
				{
					$msg = "What do you say, chummer?";
				}
				else
				{
					$msg = "I will follow you for a while for... let's say... {$price} bucks.";
					$player->setTemp($t, 1);
				}
				break;
				
			case 'yes':
				if ($player->hasTemp($t))
				{
					$msg = $this->onHire($player, $price, $time);
					$player->unsetTemp($t);
				}
				else
				{
					$msg = "Yes! Have a seat.";
				}
				break;
				
			case 'no':
				if ($player->getTemp($t))
				{
					$player->unsetTemp($t);
				}
				$msg = "Then not.";
				break;
				
			default:
				$msg = "What's up, chummer?";
				break;
		}
		
		$this->reply($msg);
	}
}
?>