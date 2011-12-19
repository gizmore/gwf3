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
					$this->reply('Well ... give him that from me:');
					SR_NPC::createEnemyParty('Seattle_BMGuy')->fight($player->getParty(), true);
				}
				else
				{
					$this->reply('Yeah, I have heard from you. I have nothing todo though.');
				}
				return;				

			case 'magic': $this->reply('There is no magic in a good weapon.'); break;
			case 'renraku': $this->reply('You don\'t have trouble with renraku, do you?'); break;
			case 'blackmarket': $this->reply('I\'d call it graymarket.'); break;
				
			case 'negotiation':
				$this->reply('Yes, all want to negotiate nowadays.');
				return;
			
			case 'yes':
			case 'no':
			default: $this->reply('Come buy hot stuff!');
		}
	}

	public function getNPCLoot(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Johnson3');
		return $quest->dropCollar($this, $player);
	}
}
?>