<?php
final class Item_LeatherCap extends SR_Helmet
{
	public function getItemLevel() { return 4; }
	public function getItemPrice() { return 79; }
	public function getItemWeight() { return 390; }
	public function getItemDescription() { return 'A sloppy brown leather cap. Looks ok.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.15,
			'marm' => 0.3,
			'farm' => 0.2,
		);
	}
}
?>