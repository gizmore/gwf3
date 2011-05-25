<?php
final class Item_Blouse extends SR_Armor
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 200; }
	public function getItemWeight() { return 550; }
	public function getItemDescription() { return 'A light red blouse. Not very protective.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.2,
			'marm' => 0.1,
			'farm' => 0.2,
			'charisma' => 0.2,
		);
	}
	
}