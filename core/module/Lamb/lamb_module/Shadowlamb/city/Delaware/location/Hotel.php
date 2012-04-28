<?php
final class Delaware_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_Hotelier'); }
	public function getFoundPercentage() { return 100.00; }
	
	public function getFoundText(SR_Player $player) { return 'You find a Hotel. A sign reads: "Rooms, 80 Nuyen a day".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Hotel. You see the Hotelier and walk to the counter.'; }
	public function getHelpText(SR_Player $player) { return "Use #talk to talk to the hotelier."; }
	
	public function getSleepPrice(SR_Player $player)
	{
		$nego = $player->get('negotiation');
		return Common::clamp(80-$nego, 40, 80);
	}
}
?>
