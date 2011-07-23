<?php
class DavyHasselhoff extends Item_Moped
{
	public function getItemDescription() { return 'This motorbike is a David Hasselhof themed Harley Davidson from the two-twenties.'; }
	public function getItemPrice() { return 6500; }
	
	public function getMountWeight() { return 6000; }
	public function getMountPassengers() { return 2; }
	public function getMountLockLevel() { return 2; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.95; }
	
}
?>
