<?php
final class Item_UM_Ring extends SR_Ring
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return 1000; }
	public function getItemDescription() { return 'A ring made by the magic council.'; }
	public function getItemDropChance() { return 50.00; }
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default: $back['attack'] = 0.5;
		}
		return $back;
	}
}
?>