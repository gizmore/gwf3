<?php
final class Hideout_HiddenStorage extends SR_SearchRoom
{
	public function getAreaSize() { return 8; }
	public function getSearchLevel() { return 6; }
	public function getFoundPercentage() { return 15.00; }
	
// 	public function getFoundText(SR_Player $player) { return 'What is that... You found the entrance to a hidden storage room!'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the hidden storage room.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "In this location you can use {$c}search, to look for hidden items."; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
}
?>
