<?php
class Cave_Tunnel1 extends SR_Location
{
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFoundPercentage() { return 70; }
	public function getLangfileName() { return 'Cave_Tunnel1'; }
}
?>
