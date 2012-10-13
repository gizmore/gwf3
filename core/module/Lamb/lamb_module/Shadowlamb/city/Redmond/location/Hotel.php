<?php
final class Redmond_Hotel extends SR_Hotel
{
	public function getNPCS(SR_Player $player) { return array('talk' => 'Redmond_Hotelier'); }
// 	public function getFoundText(SR_Player $player) { return 'You find a small Hotel. Looks a bit cheap but should suite your needs.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Redmond Hotel... Somehow you feel home here.'; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getFoundPercentage() { return 100.00; }

	public function isExitAllowed(SR_Player $player)
	{
		if (!SR_Quest::getQuest($player, 'Renraku_I')->isAccepted($player))
		{
			$player->message(Shadowhelp::getHelp($player, 'first_talk'));
			return false;
		}
		return true;
	}
}
?>