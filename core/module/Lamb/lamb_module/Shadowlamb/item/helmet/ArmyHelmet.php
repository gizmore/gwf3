<?php
final class Item_ArmyHelmet extends SR_Helmet
{
	public function getItemLevel() { return 19; }
	public function getItemPrice() { return 900; }
	public function getItemWeight() { return 1100; }
	public function getItemDescription() { return 'A quite protective and light helmet.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.3,
			'marm' => 0.6,
			'farm' => 1.0,
		);
	}
}
?>