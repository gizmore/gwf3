<?php
final class Item_Famstar2400 extends SR_Mount
{
	public function getItemDescription() { return 'An old and used minivan for the family produced by Toyota, but it\'s in good shape. It has 2400ccm and 80kg storage with a maxspeed of 155km/h.'; }
	public function getItemPrice() { return 2500.00; }
	
	public function getMountWeight() { return 80000; }
	public function getMountPassengers() { return 6; }
	public function getMountLockLevel() { return 5; }
	public function getMountTime($eta) { return $eta * 0.70; }
}
?>
