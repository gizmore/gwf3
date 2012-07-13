<?php
final class Item_Moonstone extends SR_Amulet
{
	public function getItemLevel() { return 25; }
	public function getItemPrice() { return 600; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'intelligence' => 2.0,
		);
	}
}
?>
