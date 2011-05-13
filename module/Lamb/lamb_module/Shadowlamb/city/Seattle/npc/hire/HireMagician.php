<?php
final class Seattle_HireMagician extends SR_HireNPC
{
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
			'base_mp' => rand(8, 16),
			'magic' => rand(4, 5),
			'intelligence' => rand(2, 4),
			'wisdom' => rand(2, 4),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun':
			case 'yes':
			case 'no':
			case 'hire':
				
			default: $msg = ""; break;
		}
		$this->reply($msg);
	}
	
//	public function __construct ()
//	{
//		$sql_array = array(
//			"class" => "Seattle_HireMagician",
//			"name"  => "Frosty",
//			"strength"  => 2,
//			"firearms"  => 3,
//			"pistols"   => 4,
//			"quickness" => 3,
//			"armor"  => "Clothes",
//			"weapon" => "LeatherVest",
//			"spells" => "heal:3,fireball:4",
//			"nuyen"  => 350,
//			"power"  => 0,
//			"initial_hp" => 25,
//			"initial_mp" => 50,
//		);
//		parent::__construct( $sql_array );
//	}
}
