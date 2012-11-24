<?php
final class Forest_Farm extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Forest_Farmer'); }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFoundPercentage() { return 15; }
}
?>
