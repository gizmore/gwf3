<?php
final class Item_AramitVest extends SR_Armor
{
	public function getItemLevel() { return 24; }
	public function getItemPrice() { return 2500; }
	public function getItemWeight() { return 1350; }
	public function getItemUsetime() { return 100; }
	public function isItemDropable() { return false; }
	public function getItemDescription() { return 'The military version of a kevlar vest. Better compounds and factory.'; }
	public function getItemRequirements() { return array('strength'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.7,
			'marm' => 1.8,
			'farm' => 2.9,
		);
	}
}
?>