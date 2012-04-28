<?php
final class TrollHQ2_DiningRoom extends SR_SearchRoom
{
	public function getFoundPercentage() { return 80; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }

	public function getAreaSize() { return 14; }
	public function getSearchLevel() { return 9; }
	public function getSearchMaxAttemps() { return 2; }
	
	public function getSearchLoot(SR_Player $player)
	{
		$amt = SR_PlayerVar::getVal($player, 'TR_HQ2_DR', 0);
		if ($amt > 1)
		{
			return parent::getSearchLoot($player);
		}
		
		SR_PlayerVar::setVal($player, 'TR_HQ2_DR', $amt+1);
		return array(SR_Item::createByName('LargeBeer'));
	}
}
?>
