<?php
final class Item_Ammo_Arrow extends SR_Ammo
{
	public function getItemPrice() { return 250; }
	public function getItemDefaultAmount() { return 50; }
	public function getItemWeight() { return 55; }
	public function getItemDescription() { return 'An arrow is ammo for a bow.'; }
}
?>