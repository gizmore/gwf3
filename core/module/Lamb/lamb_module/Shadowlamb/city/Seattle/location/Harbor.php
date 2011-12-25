<?php
final class Seattle_Harbor extends SR_Tower
{
	public function getFoundPercentage() { return 40.00; }
	public function getEnterText(SR_Player $player) {}
	public function getFoundText(SR_Player $player) { return 'You found the Seattle harbor. A big area for ships and stuff.'; }
	public function onEnter(SR_Player $player)
	{
		$player->getParty()->notice('You enter the Harbor ...');
		return $this->teleport($player, 'Harbor_Exit');
	}
}
?>