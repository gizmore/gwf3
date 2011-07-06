<?php
final class Item_TankTop extends SR_Armor
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 49.95; }
	public function getItemWeight() { return 550; }
	public function getItemDescription() { return 'A light tank top for the ladies. Not protective.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.05,
			'farm' => 0.1,
			'charisma' => 0.5,
		);
	}
	
}