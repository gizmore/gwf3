<?php
final class Seattle_Forest extends SR_Tower
{
	public function getFoundPercentage() { return 15.0; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function onEnter(SR_Player $player)
	{
		$this->partyMessage($player, 'enter');
		return $this->teleportInside($player, 'Forest_Exit');
	}
}
?>
