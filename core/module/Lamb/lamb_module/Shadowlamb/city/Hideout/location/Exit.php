<?php
final class Hideout_Exit extends SR_Exit
{
	public function getEnterText(SR_Player $player) { return 'You enter the punk`s hideout.'; }
	public function getExitLocation() { return 'Redmond_Hideout'; }
}
?>