<?php
final class Item_AramitGloves extends SR_Gloves
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 600; }
	public function getItemWeight() { return 200; }
	public function getItemDescription() { return 'Hard Aramit gloves are worn by special forces.'; }
	public function isItemLootable() { return false; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'marm' => '0.5',
			'farm' => '1.0',
		);
	}
}
?>
