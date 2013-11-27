<?php
final class TrollCellar_Storage2 extends SR_SearchRoom
{
	public function getAreaSize() { return 12; }
	public function getSearchLevel() { return 8; }
	public function getSearchMaxAttemps() { return 1; }
	public function getFoundPercentage() { return 50.00; }

	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function getSearchLoot(SR_Player $player)
	{
		$amt = SR_PlayerVar::getVal($player, 'TR_CE_2', 0);
		if ($amt >= 2)
		{
			return parent::getSearchLoot($player);
		}
		SR_PlayerVar::setVal($player, 'TR_CE_2', $amt+1);
		return array(SR_Item::createByName('SparklingWine'));
	}
	
}
?>
