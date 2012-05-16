<?php
abstract class SR_Gloves extends SR_Equipment
{
	public function displayType() { return 'Gloves'; }
	public function getItemType() { return 'gloves'; }
	public function getItemEquipTime() { return $this->getItemUsetime() * 2.8; }
	public function getItemUnequipTime() { return $this->getItemUsetime() * 1.8; }
}
?>
