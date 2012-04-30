<?php
require_once 'SR_MeleeWeapon.php';

abstract class SR_MagicWeapon extends SR_MeleeWeapon
{
	public function displayType() { return 'Magic Weapon'; }

	public function getItemModifiersW(SR_Player $player)
	{
		$ma = $player->get('magic');
		$cas = $player->get('casting');
		$orc = $player->get('orcas');
		return array(
			'attack'   => 2.0 + round($ma*1.0 + $cas*0.7 + $orc*0.3, 1), # 2.0
			'min_dmg'  => 0.3 + round($ma*0.1 + $cas*0.1 + $orc*0.1, 1), # 0.3
			'max_dmg'  => 0.6 + round($ma*0.3 + $cas*0.2 + $orc*0.1, 1), # 0.6
		);
	}
}
?>
