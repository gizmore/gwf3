<?php
final class Item_KevlarHelmet extends SR_Helmet
{
	public function getItemLevel() { return 16; }
	public function getItemPrice() { return 4500; }
	public function getItemWeight() { return 1400; }
	public function getItemDescription() { return 'A quite protective and light helmet.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.8,
			'farm' => 1.2,
		);
	}
}
?>