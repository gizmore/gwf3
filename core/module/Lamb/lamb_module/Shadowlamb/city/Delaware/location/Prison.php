<?php
final class Delaware_Prison extends SR_Tower
{
	public function getFoundText(SR_Player $player) { return 'You found the local prison. High walls with a barbwire topping surround it.'; }
	public function getHelpText(SR_Player $player) { return false; }
	public function getEnterText(SR_Player $player) { return ""; }
	public function onEnter(SR_Player $player)
	{
		$player->getParty()->notice('You enter the prison ...');
		$this->teleport($player, 'Prison_Exit');
	}
}
?>