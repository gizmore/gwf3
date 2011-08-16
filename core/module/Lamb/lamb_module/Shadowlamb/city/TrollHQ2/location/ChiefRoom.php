<?php
final class TrollHQ2_ChiefRoom extends SR_Location
{
	public function getFoundText(SR_Player $player) { return "You found a room with a sign \"Larry's residence\". It seems like the chief room."; }
	public function getEnterText(SR_Player $player) { return "You enter the room and spot some orks and trolls, gathering around a big troll which looks like the leader."; }
	public function getHelpText(SR_Player $player) { return "You can use #talk here to talk to Larry."; }
	public function getNPCS(SR_Player $player) { return array('talk'=>'TrollHQ2_TrollChief'); }
}
?>