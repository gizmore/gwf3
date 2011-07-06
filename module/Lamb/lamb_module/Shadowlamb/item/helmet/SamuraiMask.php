<?php
final class Item_SamuraiMask extends SR_Helmet
{
	public function getItemLevel() { return 9; }
	public function getItemPrice() { return 1500; }
	public function getItemWeight() { return 650; }
	public function getItemDescription() { return 'A golden ornamented mask to scare enemies.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.4,
			'marm' => 1.2,
			'farm' => 0.6,
		);
	}
}
?>