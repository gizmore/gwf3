<?php
final class Seattle_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Hotelier'); }
	public function getFoundText() { return 'You find a Hotel. A sign reads: "Rooms, 40 Nuyen a day".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Seattle Hotel. You see the Hotelier and walk to the counter.'; }
	public function getHelpText(SR_Player $player) { return "Use #talk to talk to the hotelier."; }
	public function getFoundPercentage() { return 80.00; }
	
	public function getSleepPrice(SR_Player $player)
	{
		$nego = $player->get('negotiation');
		return Common::clamp(40-$nego, 30, 40);
	}
}
?>