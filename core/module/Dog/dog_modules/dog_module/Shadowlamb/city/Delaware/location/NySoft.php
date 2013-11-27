<?php
final class Delaware_NySoft extends SR_Tower
{
	public function getFoundPercentage() { return 25.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function onEnter(SR_Player $player)
	{
		$this->partyMessage($player, 'enter');
		$this->teleportInside($player, 'NySoft_Exit');
	}
}
?>
