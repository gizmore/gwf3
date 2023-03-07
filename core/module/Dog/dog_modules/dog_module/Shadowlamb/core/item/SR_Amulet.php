<?php
require_once 'SR_Equipment.php';

abstract class SR_Amulet extends SR_StattedEquipment
{
	public function displayType() { return 'Amulet'; }
	public function getItemType() { return 'amulet'; }
	public function getItemWeight() { return 200; }
	public function getItemEquipTime() { return 120; }
	public function getItemUnequipTime() { return 40; }
}
