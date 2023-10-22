<?php
require_once 'SR_Weapon.php';

abstract class SR_MeleeWeapon extends SR_Weapon
{
	public function displayType() { return 'Melee Weapon'; }
	public function getItemSubType() { return 'melee'; }
	public function getItemRange() { return 2.0; }
	public function getItemEquipTime() { return 35; }
	public function getItemUnequipTime() { return 25; }
	
	public function onReload(SR_Player $player) { $player->msg('1169'); } # You can not reload a melee weapon? Oo
	
	public function onAttack(SR_Player $player, $arg)
	{
		return $this->onAttackB($player, $arg, 'marm');
	}
	
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = $player->get('melee');
		$nin = $player->get('ninja');
		
		return array(
			'attack' =>  3.0 + round($st*1.0 + $mel*2.5, 1), # 3.5
			'min_dmg' => 0.7 + round($st*0.2 + $mel*0.5, 1), # 0.7
			'max_dmg' => 1.7 + round($st*0.5 + $mel*1.2, 1), # 1.7
//			'attack' =>  round($st*0.5 + $mel*2.0, 1), # 2.5
//			'min_dmg' => round($st*0.1 + $mel*0.2, 1), # 0.3
//			'max_dmg' => round($st*0.1 + $mel*0.5, 1), # 0.6
		);
	}
}

abstract class SR_Sword extends SR_MeleeWeapon
{
	public function displayType() { return 'Sword'; }
	public function getItemSubType() { return 'swordsman'; }
	public function getItemRange() { return 2.5; }
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = $player->get('melee');
		$sub = $player->get('swordsman');
		return array(
			'attack'   => 3.0 + round($st*1.1 + $mel*1.1 + $sub*1.5, 1), # 3.7
			'min_dmg'  => 0.9 + round($st*0.2 + $mel*0.1 + $sub*0.2, 1), # 0.5
			'max_dmg'  => 1.5 + round($st*0.6 + $mel*0.7 + $sub*0.7, 1), # 2.0
		);
	}
}

abstract class SR_Axe extends SR_MeleeWeapon
{
	public function displayType() { return 'Axe'; }
	public function getItemSubType() { return 'viking'; }
	public function getItemRange() { return 1.6; }
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = $player->get('melee');
		$sub = $player->get('viking');
		return array(
			'attack'   => 3.0 + round($st*1.8 + $mel*0.7 + $sub*0.8, 1), # 3.3
			'min_dmg'  => 0.9 + round($st*0.2 + $mel*0.2 + $sub*0.3, 1), # 0.7
			'max_dmg'  => 1.5 + round($st*1.3 + $mel*0.5 + $sub*0.5, 1), # 2.3
		);
	}
}

?>
