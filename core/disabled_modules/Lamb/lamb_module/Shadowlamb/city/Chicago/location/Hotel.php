<?php
final class Chicago_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Hotelier', 'ttw'=>'Chicago_HotelWoman'); }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getFoundPercentage() { return 100.00; }
	
	public function getSleepPrice(SR_Player $player)
	{
		$nego = $player->get('negotiation');
		return Common::clamp(150-$nego*2, 40, 150);
	}
}
?>
