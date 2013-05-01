<?php
abstract class SR_Ring extends SR_StattedEquipment
{
	public function displayType() { return 'Ring'; }
	public function getItemType() { return 'ring'; }
	public function getItemWeight() { return 150; }
	public function getItemEquipTime() { return (int)($this->getItemUsetime() * 1.2); }
	public function getItemUnequipTime() { return (int) ($this->getItemUsetime() * 2.0); }
}
?>
