<?php
final class Item_UM_Earring extends SR_Earring
{
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 1000; }
	public function getItemDropChance() { return 13.00; }
	public function getItemDescription() { return 'A magic earring, smithed by the old dwarfes.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'strength' => 2,
			'luck' => 1,
		);
	}
}
?>