<?php
abstract class SR_Shield extends SR_Equipment
{
	public function displayType() { return 'Shield'; }
	public function getItemType() { return 'shield'; }
	public function getItemUsetime() { return 30; }
}
?>