
<?php
final class Item_SportQuattro extends SR_Mount
//gizmore: can do pull request for a ploxroad camouflage

{
	public function getItemDescription() { return "Sport Quattro S1 E2. The dominating 80's Group B rally car developed by Audi. All-wheel drive, turbocharged 5-cyl 2,110cc."; }
	public function getItemPrice() { return 2133; }
//					old car.
	public function getMountPassengers() { return 2; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'lock' => '0',
			'tuneup' => '25.00',
			'transport' => '2.00',
//					because racecar. unused mount capacity will be padded with bratwurst 
//					to meet minimum weight and handicap regulations. (history fun-fact!)
		);
	}
}
?>
