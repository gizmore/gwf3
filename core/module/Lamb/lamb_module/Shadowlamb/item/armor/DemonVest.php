<?php
final class Item_DemonVest extends SR_Armor
{
	public function getItemLevel() { return 28; }
	public function getItemPrice() { return 1700; }
	public function getItemWeight() { return 1250; }
	public function getItemUsetime() { return 90; }
	public function getItemDropChance() { return 20.0; }
	public function getItemDescription() { return 'A dark glowing vest which looks dangerous. It looks like it bleeds.'; }
	public function getItemRequirements() { return array('strength'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.8,
			'marm' => 1.8,
			'farm' => 2.3,
		);
	}
}
?>
