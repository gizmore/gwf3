<?php
final class Item_LeatherGloves extends SR_Gloves
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 260; }
	public function getItemDescription() { return 'Brown slim leather gloves. Good grip for melee weapons.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.1',
			'melee' => '0.2',
			'marm' => '0.1',
		);
	}
}
?>
