<?php
final class Item_DroneArmor extends SR_Armor
{
	public function getItemLevel() { return -1; }
	public function getItemPrice() { return 0; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Drone armory implemented as special item.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
		);
	}
}
?>