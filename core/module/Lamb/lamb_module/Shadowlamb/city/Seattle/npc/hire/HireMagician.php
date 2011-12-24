<?php
final class Seattle_HireMagician extends SR_HireNPC
{
	public function getName() { return $this->getPartyID() > 0 ? parent::getName() : 'The magician'; }
	public function getNPCLevel() { return 8; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Staff',
			'armor' => 'FineRobe',
			'legs' => 'Trousers',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'strength' => rand(3, 4),
			'quickness' => rand(2, 3),
			'distance' => rand(6, 8),
			'nuyen' => rand(140, 180),
			'base_hp' => rand(6, 14),
			'base_mp' => rand(30, 40),
			'magic' => rand(4, 5),
			'intelligence' => rand(2, 4),
			'wisdom' => rand(2, 4),
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
				return $this->reply("I am one of the best runners you can get. Wanna hire?");
				
			case 'yes':
				return $this->reply("Yes, {$b}hire{$b} me and i'll aid you in combat.");
			case 'no':
				return $this->reply("I am good with magic, but not with reading minds.");
			case 'hire':
				return $this->onHire($player, $price, $time);
				
			default: $msg = "Hello chummer, need a partner?"; break;
		}
		$this->reply($msg);
	}
}
?>
