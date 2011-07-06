<?php
final class Item_ChainVest extends SR_Armor
{
	public function getItemLevel() { return 9; }
	public function getItemPrice() { return 850; }
	public function getItemWeight() { return 3500; }
	public function getItemDescription() { return 'A heavy chainvest. Used in arenas for melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 2.0,
			'farm' => 1.3,
		);
	}
}
?>