<?php
require_once Shadowrun4::getShadowDir().'city/Renraku/location/Elevator.php';
final class Renraku02_Elevator extends Renraku_Elevator
{
	public function getExitLocation() { return 'Renraku03_Elevator'; }
}
?>
