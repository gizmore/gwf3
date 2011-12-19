<?php
final class Chicago_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Hotelier', 'ttw'=>'Chicago_HotelWoman'); }
	public function getFoundText(SR_Player $player) { return 'You find a Hotel. A sign reads: "Rooms, 160 Nuyen a day".'; }
	public function getEnterText(SR_Player $player) { return 'You enter the Hotel. You see the Hotelier and walk to the counter. You also see a suspicios woman in a loungy corner.'; }
	public function getHelpText(SR_Player $player) { return "Use #talk to talk to the hotelier. Use #ttw to talk to the woman."; }
	public function getFoundPercentage() { return 100.00; }
	
	public function getSleepPrice(SR_Player $player)
	{
		$nego = $player->get('negotiation');
		return Common::clamp(150-$nego*2, 40, 150);
	}
}
?>