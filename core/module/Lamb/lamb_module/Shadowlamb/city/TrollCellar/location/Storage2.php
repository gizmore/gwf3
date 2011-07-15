<?php
final class TrollCellar_Storage2 extends SR_SearchRoom
{
	public function getEnterText(SR_Player $player) {}
	public function getSearchLevel() { return 8; }
	public function getSearchMaxAttemps() { return 1; }
	public function getSearchLoot(SR_Player $player)
	{
		$amt = SR_PlayerVar::getVal($player, 'TR_CE_1', 0);
		if ($amt >= 2)
		{
			return parent::getSearchLoot($player);
		}
		SR_PlayerVar::setVal($player, $key, $amt+1);
		return array('SparklingWine');
	}
	
}
?>