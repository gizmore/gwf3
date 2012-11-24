<?php
final class Chicago_MeleeRange extends SR_School
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Chicago_Monnino'); }
	public function getFoundPercentage() { return 70.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFields(SR_Player $player)
	{
		return array(
			array('swordsman', 2000),
			array('viking', 2500),
			array('sharpshooter', 1500),
		);
	}
}
?>