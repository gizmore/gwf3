<?php
abstract class SR_MeleeWeapon extends SR_Weapon
{
	public function getItemSubType() { return 'melee'; }
	public function getItemRange() { return 0.50; }

	public function onReload(SR_Player $player) { $player->message('You can not reload a melee weapon? Oo'); }
	
	public function getItemModifiersW(SR_Player $player)
	{
		return array(
			'attack' => round($player->get('strength')+$player->get('melee')*1.5, 1),
			'max_dmg' => round($player->get('melee') * 1.25, 1),
		);
	}
	
	public function onAttack(SR_Player $player, $arg)
	{
		return $this->onAttackB($player, $arg, 'marm');
	}
}

abstract class SR_NinjaWeapon extends SR_MeleeWeapon
{
	public function getItemSubType() { return 'ninja'; }
	public function getItemModifiersW(SR_Player $player)
	{
		return array(
			'attack' => round($player->get('strength')+$player->get('melee')*2+$player->get('ninja')/2, 1),
			'max_dmg' => round($player->get('ninja')/2, 1),
			'min_dmg' => round($player->get('ninja')/4, 1),
		);
	}
}
?>