<?php
final class Item_Ammo_5mm extends SR_Ammo
{
	public function getItemLevel() { return 3; }
	public function getItemPrice() { return .17; }
	public function getItemWeight() { return 1; }
	public function getItemDefaultAmount() { return 150; }
	public function getItemDescription() { return '5.44mm bullets are mostly used in machine guns.'; }
}
?>