<?php
final class Item_BikerGloves extends SR_Gloves
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 39; }
	public function getItemWeight() { return 320; }
	public function getItemDescription() { return 'Black thick biker gloves. Best worn when riding a motorbike.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => '0.3',
			'farm' => '0.1',
		);
	}
}
?>
