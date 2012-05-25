<?php
final class Item_Piercing extends SR_Piercing
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 0; }
	public function getItemWeight() { return 50; }
	public function getItemDropChance() { return 0; }
	public function getItemDescription() { return 'A rune which got pierced into your body.'; }
}
?>
