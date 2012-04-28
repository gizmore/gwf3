<?php
final class TrollHQ2_Bedroom extends SR_Location
{
	public function getFoundPercentage() { return 80; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>
