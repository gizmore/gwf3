<?php
abstract class SR_Boots extends SR_Equipment
{
	public function displayType() { return 'Boots'; }
	public function getItemType() { return 'boots'; }
	public function getItemEquipTime() { return $this->getItemUsetime() * 2; }
	public function getItemUnequipTime() { return $this->getItemUsetime() * 2; }
}
?>
