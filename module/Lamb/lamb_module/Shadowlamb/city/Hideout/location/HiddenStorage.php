<?php
final class Hideout_HiddenStorage extends SR_SearchRoom
{
	public function getSearchLevel() { return 6; }
	public function getFoundPercentage() { return 15.00; }
	public function getFoundText(SR_Player $player) { return 'What is that... you found the entrance to a hidden storage room!'; }
	public function getEnterText(SR_Player $player) { return 'You enter the hidden storage room.'; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "In this location you can use {$c}search, to look for hidden items."; }
}
?>