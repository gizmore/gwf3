<?php
final class Prison_Exit extends SR_Exit
{
	public function getEnterText(SR_Player $player) { return 'You arrive in the prisons public entrance.'; }
	public function getExitLocation() { return 'Delaware_Prison'; }
}
?>