<?php
final class Item_Yugake extends SR_Gloves
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 320; }
	public function getItemDescription() { return 'The Yugake are gloves from japanese archers.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.2',
			'melee' => '0.2',
			'marm' => '0.3',
		);
	}
}
?>
