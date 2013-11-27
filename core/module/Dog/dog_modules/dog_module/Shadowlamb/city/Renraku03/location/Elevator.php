<?php
require_once Shadowrun4::getShadowDir().'city/Renraku/location/Elevator.php';
final class Renraku03_Elevator extends Renraku_Elevator
{
	public function getExitLocation() { return 'Renraku04_Elevator'; }
}
?>
