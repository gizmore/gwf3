<?php
final class Item_TinfoilCap extends SR_Helmet
{
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 10; }
	public function getItemWeight() { return 250; }
	public function getItemDescription() { return 'A cap made of tinfoil. Protects against alien mindbenders.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.1,
			'farm' => 0.1,
		);
	}
	
}
?>