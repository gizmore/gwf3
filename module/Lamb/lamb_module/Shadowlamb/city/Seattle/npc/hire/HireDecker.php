<?php
final class Seattle_HireDecker extends SR_HireNPC
{
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
		);
	}
	public function getNPCInventory() { return array('AT1024','Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm'); }
	public function getNPCCyberware() { return array('Headcomputer'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(2, 3),
			'quickness' => rand(4, 5),
			'distance' => rand(6, 8),
			'nuyen' => rand(80, 140),
			'base_hp' => rand(6, 12),
			'intelligence' => rand(5, 6),
			'wisdom' => rand(4, 5),
			'computers' => rand(4, 5),
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
				return $this->reply("Yes, {$b}hire{$b} me and i'll aid you in combat.");
			case 'no':
				return $this->reply("I am good with magic, but not with reading minds.");
			case 'hire':
				
				
			default: $msg = ""; break;
		}
		$this->reply($msg);
	}
}
?>