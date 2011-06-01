<?php
final class Item_Horse extends SR_Mount
{
	public function getItemDescription() { return 'You can even own a horse. Awesome!'; }
	public function getItemPrice() { return 8000; }
	
	public function getMountWeight() { return 6000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 1; }
	public function getMountTime($eta) { return $eta * 0.8; }
}
?>
