<?php
final class Item_ChainMail extends SR_Armor
{
	public function getItemLevel() { return 12; }
	public function getItemPrice() { return 7250; }
	public function getItemWeight() { return 8500; }
	public function getItemDescription() { return 'A heavy chain mail. You would look like a knight when wearing it.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 2.5,
			'farm' => 1.2,
		);
	}
}
?>