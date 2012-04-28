<?php
final class Delaware_Library extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttg'=>'Delaware_LibGnome'); }
	public function getFoundPercentage() { return 20.0; }
	
// 	public function getFoundText(SR_Player $player) { return 'You found the small local library... "Not Pringles again", you think by yourself.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the library. It is small but well sorted. In a corner you spot a fountain and a gnome.'; }
// 	public function getHelpText(SR_Player $player) { return 'You can use #ttg to talk to the gnome here.'; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
