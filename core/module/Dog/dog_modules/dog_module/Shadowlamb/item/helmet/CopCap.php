<?php
final class Item_CopCap extends SR_Helmet
{
	public function getItemLevel() { return 7; }
	public function getItemPrice() { return -1; }
	public function getItemWeight() { return 300; }
	public function getItemDescription() { return 'A useless copcap. Maybe a fun trophy.'; }
	public function getItemDropChance() { return 40.0; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
}
?>