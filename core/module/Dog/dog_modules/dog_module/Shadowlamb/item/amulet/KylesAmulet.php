<?php
final class Item_KylesAmulet extends SR_Amulet
{
	public function getItemDescription() { return 'A golden amulet with a big Hematite. The names Kyle and Ilona are engraved on it.'; }
	public function getItemWeight() { return 650; }
	public function getItemPrice() { return 449.95; }
	public function getItemDropChance() { return 0.0; }
	public function getItemLevel() { return 25; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'charisma' => 1.5,
			'spelldef' => 2.0,
			'intelligence' => 2.0,
		);
	}
}
?>