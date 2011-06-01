<?php
final class Item_ChainHelmet extends SR_Helmet
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 2200; }
	public function getItemWeight() { return 1250; }
	public function getItemDescription() { return 'A metal helmet for melee combat.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 1.8,
			'farm' => 0.8,
		);
	}
}
?>