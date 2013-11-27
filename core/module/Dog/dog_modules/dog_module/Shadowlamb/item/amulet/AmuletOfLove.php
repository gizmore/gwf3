<?php
class Item_AmuletOfLove extends SR_Amulet
{
	public function getItemLevel() { return 10; }
	public function getItemDescription() { return 'A golden amulet in a shape of a rose with a large red rubin looking like a heart. It\'s glowing bright red and you feel like you are in love.'; }
	public function getItemDropChance() { return 5.00; }
	public function getItemPrice() { return 1000; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'max_mp' => 10,
			'luck' => 1,
			'charisma' => 1,
		);
	}
}
?>