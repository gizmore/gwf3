<?php
final class Item_ScorpionLegs extends SR_Legs
{
	public function getItemLevel() { return 34; }
	public function getItemPrice() { return 950; }
	public function getItemWeight() { return 1350; }
	public function getItemDescription() { return 'The lower part of a sirene skin. It is slight green and smells fishy.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.5,
			'marm' => 1.1,
			'farm' => 0.6,
		);
	}
}
?>
