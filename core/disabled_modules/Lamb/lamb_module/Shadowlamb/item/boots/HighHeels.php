<?php
final class Item_HighHeels extends SR_Boots
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 69.95; }
	public function getItemWeight() { return 375; }
	public function getItemDescription() { return 'Red high heels for the ladies. Makes you look attractive.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'defense' => 0.1,
			'marm' => 0.2,
			'farm' => 0.1,
			'charisma' => 0.5,
		);
	}
}
?>