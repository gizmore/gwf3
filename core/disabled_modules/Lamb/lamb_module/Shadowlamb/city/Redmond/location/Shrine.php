<?php
final class Redmond_Shrine extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_Ninja'); }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
// 	public function getFoundText(SR_Player $player) { return 'You found the Redmond Shrine. It is a place for monks to find peace.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the shrine. A peaceful place where you see some monks meditating. You see a monk who is cleaning a sword.'; }
	public function getFoundPercentage() { return 60.00; }
}
?>