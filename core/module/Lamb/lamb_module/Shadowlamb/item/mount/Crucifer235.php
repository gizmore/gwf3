<?php
require_once 'DavyHasselhoff.php';
class Item_Crucifer235 extends Item_DavyHasselhoff
{
	public function getItemDescription() { return 'The Crucifer235 is a modern racing bike with a tribrid engine. It got produced from 2048 to 2064 by Cyxles.'; }
	public function getItemPrice() { return 3500; }
	
	public function getMountWeight() { return 4000; }
	public function getMountPassengers() { return 1; }
	public function getMountLockLevel() { return 3; }
	public function getMountTime($eta) { return parent::getMountTime($eta) * 0.78; }
}
?>
