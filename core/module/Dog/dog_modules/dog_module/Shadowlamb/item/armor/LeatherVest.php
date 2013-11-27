<?php
final class Item_LeatherVest extends SR_Armor
{
	public function getItemLevel() { return 3; }
	public function getItemPrice() { return 200; }
	public function getItemWeight() { return 2000; }
	public function getItemDescription() { return 'A protective vest, nice for newbie runners.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.5,
			'farm' => 0.5,
		);
	}
}
?>