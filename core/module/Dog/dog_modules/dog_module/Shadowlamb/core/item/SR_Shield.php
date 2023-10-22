<?php
require_once 'SR_Equipment.php';

abstract class SR_Shield extends SR_Equipment
{
	public function displayType() { return 'Shield'; }
	public function getItemType() { return 'shield'; }
	public function getItemUsetime() { return 30; }
	public function getItemEquipTime() { return (int)($this->getItemUsetime() * 1.5); }
	public function getItemUnequipTime() { return 30; }
}
?>
