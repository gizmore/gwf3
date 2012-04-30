<?php
abstract class SR_Helmet extends SR_Equipment
{
	public function displayType() { return 'Helmet'; }
	public function getItemType() { return 'helmet'; }
	public function getItemEquipTime() { return (int)($this->getItemUsetime() * 1.5); }
	public function getItemUnequipTime() { return (int) ($this->getItemUsetime() * 1.5); }
}
?>
