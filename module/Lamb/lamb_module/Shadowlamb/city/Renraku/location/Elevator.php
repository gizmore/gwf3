<?php
class Renraku_Elevator extends SR_Elevator
{
	public function getElevatorCity() { return $this->getCity(); }
	public function getElevatorMaxKG() { return 2000; }
	public function getElevatorTime() { return 60; }
}
?>