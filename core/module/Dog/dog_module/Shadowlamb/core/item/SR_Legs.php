<?php
abstract class SR_Legs extends SR_Equipment
{
	public function displayType() { return 'Legs'; }
	public function getItemType() { return 'legs'; }
	public function getItemEquipTime() { return (int)($this->getItemUsetime() * 2.5); }
	public function getItemUnequipTime() { return (int) ($this->getItemUsetime() * 1.5); }
}
?>