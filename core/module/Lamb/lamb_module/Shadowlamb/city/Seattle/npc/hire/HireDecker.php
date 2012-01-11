<?php
final class Seattle_HireDecker extends SR_HireNPC
{
	public function getName() { return $this->getPartyID() > 0 ? parent::getName() : 'The decker'; }
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresViper',
			'armor' => 'KevlarVest',
			'legs' => 'Trousers',
			'helmet' => 'Cap',
			'boots' => 'ArmyBoots',
			'earring' => 'Earring_of_maxhp:2',
			'shield' => 'ElvenShield',
		);
	}
	public function getNPCInventory() { return array('AT1024','Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm'); }
	public function getNPCCyberware() { return array('Headcomputer'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'darkelve',
			'gender' => 'male',
			'strength' => rand(4, 6),
			'pistols' => rand(4, 6),
			'firearms' => rand(4, 6),
			'body' => rand(4, 6),
			'quickness' => rand(6, 8),
			'distance' => rand(6, 14),
			'nuyen' => rand(20, 120),
			'base_hp' => rand(16, 28),
			'intelligence' => rand(4, 8),
			'wisdom' => rand(4, 8),
			'computers' => rand(4, 8),
		);
	}
	
	public function getNPCSpells()
	{
		return array(
			'heal' => 3,
			'firebolt' => 2,
//			'freeze' => 2,
		);
	}
	
	const MANIFESTO = 'SLHD_MANIFEST';
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$price = 800 - Common::clamp($player->get('negotiation'), 0, 10) * 10;
		$time = 1000 * $player->get('charisma') * 60;
		
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun':
				return $this->reply("I am in for a run, Do you want to {$b}hire{$b} my hacking skills?");
			case 'yes':
				return $this->reply("Yes, {$b}hire{$b} me and i'll aid you in combat and hacking.");
			case 'no':
				if ($player->hasTemp(self::MANIFESTO))
				{
					return $this->reply('Yes, no, what else?');
				}
				else
				{
					$this->reply("This is our world now... The world of the electron and the switch, the beauty of the baud.");
					$this->reply("We make use of a service already existing without paying for what could be dirt-cheap if it wasn't run by profiteering gluttons, and you call us criminals.");
					$this->reply("We explore... And you call us criminals. We seek after knowledge... And you call us criminals. We exist without skin color, without nationality, without religious bias... And you call us criminals.");
					$this->reply("You build atomic bombs, you wage wars, you murder, cheat, and lie to us and try to make us believe it's for our own good, yet we're the criminals.");
					$this->reply("Yes, I am a criminal. My crime is that of curiosity. My crime is that of judging people by what they say and think, not what they look like. My crime is that of outsmarting you, something that you will never forgive me for.");
					$this->reply("I am a hacker, and this is my manifesto. You may stop this individual, but you can't stop us all... After all, we're all alike.");
					$player->setTemp(self::MANIFESTO, 1);
					return true;
				}
				break;
			case 'hire':
				return $this->reply($this->onHire($player, $price, $time));
				
			default: return $this->reply("Need a hacker?"); break;
		}
	}
}
?>