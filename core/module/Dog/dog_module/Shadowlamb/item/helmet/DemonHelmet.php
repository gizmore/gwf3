<?php
final class Item_DemonHelmet extends SR_Helmet
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 1100; }
	public function getItemWeight() { return 1300; }
	public function getItemDescription() { return 'A dark glowing helmet with bones. It looks like it bleeds.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.9,
			'farm' => 1.3,
		);
	}
}
?>