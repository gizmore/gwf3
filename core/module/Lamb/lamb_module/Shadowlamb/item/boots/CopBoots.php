<?php
final class Item_CopBoots extends SR_Boots
{
	public function getItemLevel() { return 7; }
	public function getItemPrice() { return 450; }
	public function getItemWeight() { return 950; }
	public function getItemDescription() { return 'Black Police Office boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.5,
			'farm' => 0.4,
		);
	}
}
?>