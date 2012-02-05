<?php
abstract class SR_MeleeWeapon extends SR_Weapon
{
	public function displayType() { return 'Melee Weapon'; }
	public function getItemSubType() { return 'melee'; }
	public function getItemRange() { return 2.0; }

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
			'attack' =>  3.0 + round($st*0.5 + $mel*2.5, 1), # 3.0
			'min_dmg' => 0.7 + round($st*0.2 + $mel*0.5, 1), # 0.7
			'max_dmg' => 1.7 + round($st*0.5 + $mel*1.2, 1), # 1.7
//			'attack' =>  round($st*0.5 + $mel*2.0, 1), # 2.5
//			'min_dmg' => round($st*0.1 + $mel*0.2, 1), # 0.3
//			'max_dmg' => round($st*0.1 + $mel*0.5, 1), # 0.6
		);
	}
}
?>