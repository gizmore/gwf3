<?php
final class Chicago_University extends SR_Location
{
	public function getFoundPercentage() { return 40.0; }
	public function getFoundText(SR_Player $player) { return 'You found the Univesity of Chicago. The fassade leaves a good impression in these bad times.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the univserity and see a gnome study in a corner.'; }
	public function getHelpText(SR_Player $player) { return 'You can use #ttg to talk to the gnome here.'; }
	public function getNPCS(SR_Player $player) { return array('ttg'=>'Chicago_UniGnome'); }
}
?>