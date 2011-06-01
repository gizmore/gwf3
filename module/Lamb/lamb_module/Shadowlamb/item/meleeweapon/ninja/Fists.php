<?php
final class Item_Fists extends SR_NinjaWeapon
{
	public function getAttackTime() { return 35; }
	public static function staticFists() { return self::instance('Fists'); }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Your fists. You got two of them.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 3.0,
			'min_dmg' => 0.0,
			'max_dmg' => 3.0,
		);
	}
}
?>