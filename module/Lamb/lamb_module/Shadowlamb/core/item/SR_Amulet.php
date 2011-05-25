<?php
abstract class SR_Amulet extends SR_StattedEquipment
{
	public function displayType() { return 'Amulet'; }
	public function getItemType() { return 'amulet'; }
	public function getItemWeight() { return 200; }
}
?>