<?php
final class Item_BikerBoots extends SR_Boots
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 750; }
	public function getItemWeight() { return 850; }
	public function getItemDescription() { return 'Heavy black biker boots.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 0.4,
			'farm' => 0.2,
		);
	}
}
?>