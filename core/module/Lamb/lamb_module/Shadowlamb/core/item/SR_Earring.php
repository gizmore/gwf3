<?php
abstract class SR_Earring extends SR_StattedEquipment
{
	public function displayType() { return 'Earring'; }
	public function getItemType() { return 'earring'; }
	public function getItemWeight() { return 50; }
}
?>