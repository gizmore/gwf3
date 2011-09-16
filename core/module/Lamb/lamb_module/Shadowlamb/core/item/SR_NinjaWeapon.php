<?php
require_once 'SR_MeleeWeapon.php';

abstract class SR_NinjaWeapon extends SR_MeleeWeapon
{
	public function displayType() { return 'Ninja Weapon'; }
	public function getItemSubType() { return 'ninja'; }
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = $player->get('melee');
		$nin = $player->get('ninja');
		return array(
			'attack'   => 3.0 + round($st*0.5 + $mel*0.5 + $nin*2.0, 1), # 3.0
			'min_dmg'  => 0.9 + round($st*0.2 + $mel*0.1 + $nin*0.6, 1), # 0.9
			'max_dmg'  => 1.5 + round($st*0.5 + $mel*0.2 + $nin*0.8, 1), # 1.5
//			'attack'   => round($st*0.5 + $mel*2.0 + $nin*1.0, 1), # 3.5
//			'min_dmg'  => round($st*0.1 + $mel*0.0 + $nin*0.5, 1), # 0.6
//			'max_dmg'  => round($st*0.1 + $mel*0.0 + $nin*1.0, 1), # 1.1
		);
	}
}
?>