<?php
final class Item_FullBodyArmor extends SR_Armor
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 40000; }
	public function getItemWeight() { return 7500; }
	public function getItemRequirements() { return array('strength'=>5); }
	public function getItemDescription() { return 'A full-protective body suite, used by special forces.'; }
	public function getItemUsetime() { return 240; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.2,
			'marm' => 3.8,
			'farm' => 3.5,
		);
	}
}
?>