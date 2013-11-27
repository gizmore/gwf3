<?php
final class Seattle_Library extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttg'=>'Seattle_LibGnome'); }
	public function getFoundPercentage() { return 40.0; }
	
// 	public function getFoundText(SR_Player $player) { return 'It seems you found the local library... Booring!'; }
// 	public function getEnterText(SR_Player $player) { return 'The door is heavy and you smell old books when you enter. A fascinating place. You see a weird looking small elve or gnome, not sure.'; }
// 	public function getHelpText(SR_Player $player) { return 'You can use #ttg to talk to the elvish gnome here.'; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
