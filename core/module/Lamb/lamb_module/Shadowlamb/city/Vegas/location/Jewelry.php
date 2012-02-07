<?php
final class Vegas_Jewelry extends SR_Store
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Vegas_JewelrySalesman'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
}
?>