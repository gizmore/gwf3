<?php
final class Item_LO_Earring extends SR_Earring
{
	public function getItemLevel() { return 15; }
	public function getItemPrice() { return 500; }
	public function getItemDropChance() { return 25.00; }
	public function getItemDescription() { return 'A magic earring from the caves of Ugah!'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'luck' => 0.5,
		);
	}
}
?>