<?php
final class Item_NinjaCloak extends SR_Armor
{
	public function getItemLevel() { return 13; }
	public function getItemPrice() { return 2500; }
	public function getItemWeight() { return 900; }
	public function getItemUsetime() { return 60; }
	public function getItemDescription() { return 'A light ninja cloak. No invisible powers.'; }
//	public function getItemRequirements() { return array('ninja'=>1); }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 1.5,
			'quickness' => 1.0,
			'marm' => 0.2,
			'farm' => 0.2,
		);
	}
	
}
?>