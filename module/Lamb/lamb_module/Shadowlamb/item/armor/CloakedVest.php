<?php
final class Item_CloakedVest extends SR_Armor
{
	public function getItemLevel() { return 19; }
	public function getItemPrice() { return 7500; }
	public function getItemWeight() { return 1250; }
	public function getItemUsetime() { return 90; }
	public function getItemDescription() { return 'A long vest, ideal to hide small weapons.'; }
	public function getItemRequirements() { return array('strength'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.2,
			'marm' => 1.2,
			'farm' => 1.8,
		);
	}
}
?>