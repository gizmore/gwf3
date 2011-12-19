<?php
final class OrkHQ_ConferenceRoom extends SR_SearchRoom
{
	public function getAreaSize() { return 48; }
	public function getSearchLevel() { return 8; }
	public function getFoundPercentage() { return 65.00; }
	public function getFoundText(SR_Player $player) { return 'You locate a room with an open door. Looks like a conference room.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the room and smile when seeing a scrubbed image of an Ork on one of the walls. The room itself is quite a mess of various bags and clothes.'; }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "In this location you can use {$c}search, to look for hidden items."; }
}
?>