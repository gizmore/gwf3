<?php
abstract class SR_Belt extends SR_Equipment
{
	public function displayType() { return 'Belt'; }
	public function getItemType() { return 'belt'; }
	public function getItemEquipTime() { return $this->getItemUsetime() * 3.5; }
	public function getItemUnequipTime() { return $this->getItemUsetime() * 2.5; }
}
?>
