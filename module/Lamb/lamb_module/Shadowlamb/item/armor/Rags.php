<?php
final class Item_Rags extends SR_Armor
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 20; }
	public function getItemWeight() { return 380; }
	public function getItemDescription() { return 'More rags than clothes. Better than nothing.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.1,
			'farm' => 0.1,
		);
	}
}
?>