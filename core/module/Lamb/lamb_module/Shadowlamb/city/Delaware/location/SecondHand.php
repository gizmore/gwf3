<?php
final class Delaware_SecondHand extends SR_SecondHandStore
{
	public function getMaxItems() { return 30; }
	public function getNPCS(SR_Player $player)
	{
		$back = array();
		$back[] = array('talk' => 'Delaware_SecondHandDwarf');
		$quest = SR_Quest::getQuest($player, 'Delaware_Seraphim2');
		if ($quest->isDone($player))
		{
			$back[] = array('ttt' => 'Delaware_SecondHandTroll');
		}
		return $back;
	}
	public function getFoundPercentage() { return 40.00; }
	public function getFoundText(SR_Player $player) { return 'You found a SecondHandStore.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the second hand store. A dwarf is behind the counter and greets you.'; }
	public function getHelpText(SR_Player $player) { return 'You can sell statted items to higher prices here. The statted items that get sold here will stay in the shop.'; }
}
?>