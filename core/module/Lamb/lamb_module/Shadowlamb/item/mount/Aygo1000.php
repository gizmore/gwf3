<?php
final class Item_Aygo1000 extends SR_Mount
{
	public function getItemDescription() { return 'An old cheap and used car produced by Toyota in the twenties.'; }
	public function getItemPrice() { return 1995.00; }
	
	public function getMountWeight() { return 15000; }
	public function getMountPassengers() { return 4; }
	public function getMountLockLevel() { return 4; }
	public function getMountTime($eta) { return $eta * 0.65; }
}
?>