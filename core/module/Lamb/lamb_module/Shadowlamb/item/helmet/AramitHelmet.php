<?php
final class Item_AramitHelmet extends SR_Helmet
{
	public function getItemLevel() { return 27; }
	public function getItemPrice() { return 1600; }
	public function getItemWeight() { return 1100; }
	public function getItemDescription() { return 'Harded Aramit combat helmet. Used by the military.'; }
	public function isItemDropable() { return false; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => 1.4,
			'farm' => 2.1,
		);
	}
}
?>