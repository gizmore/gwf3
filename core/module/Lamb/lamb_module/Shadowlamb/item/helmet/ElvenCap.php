<?php
final class Item_ElvenCap extends SR_Helmet
{
	public function getItemLevel() { return 12; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 150; }
	public function getItemDescription() { return 'A small green cap. It is tight and feels weird, soft and glows a bit.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.1,
			'farm' => 0.1,
			'intelligence' => 0.4,
			'wisdom' => 0.2,
			'magic' => 0.2,
		);
	}
	
}
?>