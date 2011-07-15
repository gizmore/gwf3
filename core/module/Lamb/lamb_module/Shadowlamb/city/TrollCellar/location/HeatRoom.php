<?php
final class TrollCellar_HeatRoom extends SR_SearchRoom
{
	public function getFoundText(SR_Player $player) { return "You found a room that seems to contain the houses heating equipment."; }
	public function getEnterText(SR_Player $player) { return "You enter the heating room. The air is warm and try and it smells old."; }
}
?>