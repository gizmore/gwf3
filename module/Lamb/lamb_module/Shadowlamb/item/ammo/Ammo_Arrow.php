<?php
final class Item_Ammo_Arrow extends SR_Ammo
{
	public function getItemLevel() { return 2; }
	public function getItemPrice() { return 149.95; }
	public function getItemDefaultAmount() { return 50; }
	public function getItemWeight() { return 55; }
	public function getItemDescription() { return 'An arrow is ammo for a bow.'; }
}
?>