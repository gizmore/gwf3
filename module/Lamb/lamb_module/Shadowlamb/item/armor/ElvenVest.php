<?php
final class Item_ElvenVest extends SR_Armor
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 750; }
	public function getItemWeight() { return 1200; }
	public function getItemDescription() { return 'A light vest with low firearms protection. It is greenish.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 0.4,
			'farm' => 0.3,
			'quickness' => 0.2,
		);
	}
}
?>