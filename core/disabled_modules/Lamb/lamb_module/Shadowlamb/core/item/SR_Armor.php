<?php
abstract class SR_Armor extends SR_Equipment
{
	public function displayType() { return 'Armor'; }
	public function getItemType() { return 'armor'; }
	public function getItemEquipTime() { return $this->getItemUsetime() * 3; }
	public function getItemUnequipTime() { return $this->getItemUsetime() * 2; }
}
?>
