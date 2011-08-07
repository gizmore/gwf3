<?php
final class Item_Ammo_Arrow extends SR_Ammo
{
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 0.19; }
	public function getItemDefaultAmount() { return 25; }
	public function getItemWeight() { return 22; }
	public function getItemDescription() { return 'An arrow is ammo for a bow.'; }
}
?>