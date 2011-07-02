<?php
abstract class SR_MeleeWeapon extends SR_Weapon
{
	public function displayType() { return 'Melee Weapon'; }
	public function getItemSubType() { return 'melee'; }
	public function getItemRange() { return 2.0; }

	public function onReload(SR_Player $player) { $player->message('You can not reload a melee weapon? Oo'); }
	
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = Common::clamp($player->get('melee'), 0);
		$nin = Common::clamp($player->get('ninja'), 0);
		
		return array(
			'attack' =>  round($st*0.5 + $mel*2.0, 1),#($player->get('strength')+$player->get('melee'))*1.35, 1),
			'min_dmg' => round($st*0.1 + $mel*0.2, 1),#$player->get('melee') * 1.25, 1),
			'max_dmg' => round($st*0.1 + $mel*0.5, 1),#$player->get('melee') * 1.25, 1),
		);
	}
	
	public function onAttack(SR_Player $player, $arg)
	{
		return $this->onAttackB($player, $arg, 'marm');
	}
}

abstract class SR_NinjaWeapon extends SR_MeleeWeapon
{
	public function displayType() { return 'Ninja Weapon'; }
	public function getItemSubType() { return 'ninja'; }
	public function getItemModifiersW(SR_Player $player)
	{
		$st = $player->get('strength');
		$mel = Common::clamp($player->get('melee'), 0);
		$nin = Common::clamp($player->get('ninja'), 0);
		return array(
			'attack'   => round($st*0.5 + $mel*2.0 + $nin*1.0, 1),
			'min_dmg'  => round($st*0.1 + $mel*0.0 + $nin*0.5, 1),
			'max_dmg'  => round($st*0.1 + $mel*0.0 + $nin*1.0, 1),
//			'max_dmg' => round($player->get('melee')*0+( $player->get('ninja'))) * 1.0, 1),
//			'min_dmg' => round(($player->get('melee')+($player->get('ninja'))) * 0.1, 1),
		);
	}
}
?>