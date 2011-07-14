<?php
final class Item_KevlarVest extends SR_Armor
{
	public function getItemLevel() { return 20; }
	public function getItemPrice() { return 1500; }
	public function getItemWeight() { return 1450; }
	public function getItemUsetime() { return 90; }
	public function getItemDescription() { return 'A light vest with intermediate protection.'; }
	public function getItemRequirements() { return array('strength'=>2); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.5,
			'marm' => 1.5,
			'farm' => 2.2,
		);
	}
	
}
?>