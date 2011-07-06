<?php
final class Item_BikerHelmet extends SR_Helmet
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 350; }
	public function getItemWeight() { return 1250; }
	public function getItemDescription() { return 'A solid biker helmet'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => -0.8,
			'marm' => 2.0,
			'farm' => 1.0,
		);
	}
	
}
?>