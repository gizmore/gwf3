<?php
final class Item_TinfoilBelt extends SR_Belt
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'A belt made of tinfoil. Quite useless even with the full set.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.05,
			'marm' => 0.05,
			'farm' => 0.05,
		);
	}
}
?>
