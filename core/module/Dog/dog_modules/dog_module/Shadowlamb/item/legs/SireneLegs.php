<?php
final class Item_SireneLegs extends SR_Legs
{
	public function getItemLevel() { return 29; }
	public function getItemPrice() { return 1150; }
	public function getItemWeight() { return 1150; }
	public function getItemDescription() { return 'The lower part of a sirene skin. It is slight green and smells fishy.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.6,
			'marm' => 0.9,
			'farm' => 0.7,
		);
	}
}
?>
