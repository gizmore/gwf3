<?php
final class Item_Nihonto extends SR_Sword
{
	public function getAttackTime() { return 38; }
	public function getItemLevel() { return 23; }
	public function getItemWeight() { return 1035; }
	public function getItemPrice() { return 1450; }
	public function getItemRange() { return 2.3; }
	public function getItemDescription() { return 'A traditional Japanese Sword. Katana style, and well manufactured.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 15.5, 
			'min_dmg' => 4.5,
			'max_dmg' => 16.7,
		);
	}
}
?>