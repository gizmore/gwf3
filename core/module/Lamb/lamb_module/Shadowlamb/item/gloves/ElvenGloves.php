<?php
final class Item_ElvenGloves extends SR_Gloves
{
	public function getItemLevel() { return 5; }
	public function getItemPrice() { return 79; }
	public function getItemWeight() { return 220; }
	public function getItemDescription() { return 'Green elven gloves made of unknown material. They glow a bit greenish.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '0.2',
			'bows' => '2.0',
			'quickness' => '0.3',
			'marm' => '0.1',
		);
	}
}
?>
