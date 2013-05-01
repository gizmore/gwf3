<?php
final class Item_Katana extends SR_Sword
{
	public function getAttackTime() { return 34; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 1250; }
	public function getItemPrice() { return 1200; }
	public function getItemDescription() { return 'A white japanese Katana sword. It looks valuable and deadly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 12.5, 
			'min_dmg' => 4.5,
			'max_dmg' => 12.0,
		);
	}
}
?>