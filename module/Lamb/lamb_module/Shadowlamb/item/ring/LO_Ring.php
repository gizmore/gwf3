<?php
final class Item_LO_Ring extends SR_Ring
{
	public function getItemLevel() { return 12; }
	public function getItemDescription() { return 'A magical ring made in the caves of Ugah.'; }
	public function getItemDropChance() { return 25.00; }
	public function getItemPrice() { return 1000; }
	public function getItemModifiersA(SR_Player $player)
	{
		$back = array();
		switch($player->getRace())
		{
			default: $back['body'] = 0.5; break;
		}
		return $back;
	}
}
?>