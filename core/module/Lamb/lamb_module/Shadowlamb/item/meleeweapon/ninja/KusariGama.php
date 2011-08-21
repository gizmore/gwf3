<?php
final class Item_KusariGama extends SR_MeleeWeapon
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 15; }
	public function getItemWeight() { return 1500; }
	public function getItemPrice() { return 95; }
	public function getItemRange() { return 6.0; }
	public function getItemDescription() { return 'The Kusari-gama is a combination of a sickle (short scythe) and a long chain with a weight attached to the end of it.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 14.0, 
			'min_dmg' => 1.5,
			'max_dmg' => 13.0,
		);
	}
}
?>